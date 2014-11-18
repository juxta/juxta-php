<?php

namespace Juxta;

use Juxta\Exception\Exception;
use Juxta\Exception\SessionNotFound;
use Juxta\Db\Db;
use Juxta\Db\Exception\Connect;
use Juxta\Db\Connection;

final class App
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Connections
     */
    private $connections;

    /**
     * @var array
     */
    private $routes = [
        'show' => [
            'databases' => 'ShowDatabases',
            'processlist' => 'ShowProcesslist',
            'users' => 'ShowUsers',
            'status' => 'ShowStatus',
            'variables' => 'ShowVariables',
            'charsets' => 'ShowCharsets',
            'engines' => 'ShowEngines',
            'tables' => 'ShowTables',
            'table' => 'ShowTable',
            'indexes' => 'ShowIndexes',
            'views' => 'ShowViews',
            'view' => 'ShowCreateView',
            'routines' => 'ShowRoutines',
            'procedure' => 'ShowCreateProcedure',
            'function' => 'ShowCreateFunction',
            'triggers' => 'ShowTriggers',
            'trigger' => 'ShowCreateTrigger',
            'database-properties' => 'ShowDatabaseProperties',
            'table-properties' => 'ShowTableProperties',
            'view-properties' => 'ShowViewProperties',
            'procedure-properties' => 'ShowProcedureProperties',
            'function-properties' => 'ShowFunctionProperties',
            'trigger-properties' => 'ShowTriggerProperties',
        ],
        'create' => [
            'database' => 'CreateDatabase',
        ],
        'drop' => [
            'databases' => 'DropDatabases',
            'users' => 'DropUsers',
            'tables' => 'DropTables',
            'views' => 'DropViews',
            'triggers' => 'DropTriggers',
            'routines' => 'DropRoutines',
        ],
        'kill' => 'Kill',
        'truncate' => 'TruncateTables',
        'browse' => 'Browse',
    ];

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->connections = new Connections(new Session(), $this->config);
    }

    /**
     * @throws SessionNotFound
     * @return string
     */
    public function run()
    {
        $request = new Request($_GET + $_POST);

        $cid = $request->get('cid', 0);

        $name = $this->route($_GET);

        if ($name) {
            $connection = $this->connections->getByCid($cid);

            if (empty($connection)) {
                throw new SessionNotFound();
            }

            $name = 'Juxta\\Command\\' . $name;

            $command = new $name(Db::factory($connection));
        }

        $response = null;

        try {

            if (isset($command)) {

                $response = $command->run($request);

            } elseif (isset($_GET['login'])) {

                $response = $this->connect(Connection::extract($_POST));

            } elseif (isset($_GET['logout'])) {

                $response = $this->connections->delete($cid);

            } elseif (isset($_GET['flush'])) {

                $response = $this->connections->deleteAll();

            } elseif (isset($_GET['get']) && $_GET['get'] === 'session') {

                $response = $this->connections->getByCid($cid, true);

                if (empty($response)) {
                    throw new SessionNotFound();
                }

            } elseif (isset($_GET['get']) && $_GET['get'] === 'connections') {

                $response = $this->connections->getAll();
            }

        } catch (Exception $e) {

            $status = [
                'Juxta\Exception\SessionNotFound' => "session_not_found",
                'Juxta\Db\Exception\Connect' => "connection_error",
                'Juxta\Db\Exception\Query' => "query_error",
            ];

            $response = [
                'error' => isset($status[get_class($e)]) ? $status[get_class($e)] : 'error',
                'errormsg' => $e->getMessage(),
                'errorno' => $e->getCode()
            ];

            $response += (array)$e->getAttachment();
        }

        return json_encode($response);
    }

    /**
     * Find a command bt request
     *
     * @param array $request
     * @return string
     */
    private function route(array $request)
    {
        foreach ($this->routes as $key => $value) {
            if (array_key_exists($key, $request)) {
                if (is_array($value) && array_key_exists($request[$key], $value)) {
                    return $value[$request[$key]];

                } else if (is_string($value)) {
                    return $value;
                }
            }
        }

        return '';
    }

    /**
     * Connect to server and save connection
     *
     * @param array $connection
     * @return array|string
     */
    private function connect(array $connection)
    {
        if (empty($connection['password'])) {
            $stored = $this->connections->getByKey(Connection::key($connection));
        }

        if (!empty($stored) && array_key_exists('password', $stored)) {
            $connection['password'] = $stored['password'];
        }

        // Fail on first connection is not error
        try {
            $db = Db::factory($connection);

        } catch (Connect $e) {
            return "{$e->getCode()} {$e->getMessage()}";
        }

        $version = $db->fetchAll("SHOW VARIABLES LIKE '%version%'", Db::FETCH_ASSOC);

        foreach ($version as $row) {
            if (in_array($row['Variable_name'], array('version', 'version_comment'))) {
                $connection['server'][$row['Variable_name']] = $row['Value'];
            }
        }

        $connection = $this->connections->save($connection);

        return Connection::maskPassword($connection);
    }
}