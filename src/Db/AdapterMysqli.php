<?php

namespace Juxta\Db;

use Juxta\Db\Db;
use Juxta\Db\Exception\ConnectErrorException;
use Juxta\Db\Exception\QueryErrorException;

class AdapterMysqli implements AdapterInterface
{
    /**
     * @var \mysqli
     */
    protected $connection;

    /**
     * @param array|\mysqli
     * @throws ConnectErrorException
     */
    public function __construct()
    {
        if (!function_exists('mysqli_report')) {
            throw new ConnectErrorException('The mysqli extension is not enabled');
        }

        $arguments = func_get_args();

        if (empty($arguments)) {
            throw new ConnectErrorException('Invalid argument');
        }

        if ($arguments[0] instanceof \mysqli) {
            $this->connection = $arguments[0];

        } elseif (is_array($arguments[0])) {
            $params = Db::extract($arguments[0]);
        }

        if (!empty($params)) {
            try {
                $this->connection = @new \mysqli(
                    $params['host'],
                    $params['user'],
                    $params['password'],
                    '',
                    $params['port']
                );

                $this->connection->set_charset($params['charset']);

            } catch (\mysqli_sql_exception $exception) {
                throw new ConnectErrorException($exception->getMessage(), $exception->getCode());
            }
        }
    }

    /**
     * Prepare a row
     *
     * @param array $row
     * @param array $columns
     * @param int $type
     * @return array
     */
    protected static function prepare(array $row, array $columns = null, $type = Db::FETCH_NUM)
    {
        if (empty($columns)) {
            return $row;
        }

        $values = [];

        foreach ($columns as $column) {
            if (!array_key_exists($column, $row)) {
                continue;
            }
            if ($type === Db::FETCH_NUM || $type === Db::FETCH_BOTH) {
                $values[] = $row[$column];
            }
            if ($type === Db::FETCH_ASSOC || $type === Db::FETCH_BOTH) {
                $values[$column] = $row[$column];
            }
        }

        return $values;
    }

    /**
     * Fetch one or all result rows as an associative, a numeric array, or both
     *
     * @param \mysqli_result $result
     * @param array $columns
     * @param int $type
     * @param bool $fetchRow
     * @return array
     */
    protected static function fetch(\mysqli_result $result, $columns = null, $type = Db::FETCH_NUM, $fetchRow = false)
    {
        if (is_bool($type)) {
            $fetchRow = $type;
            $type = Db::FETCH_NUM;
        }

        if (is_numeric($columns)) {
            $type = $columns;
            $columns = [];
        }

        $map = [
            Db::FETCH_ASSOC => MYSQLI_ASSOC,
            Db::FETCH_NUM => MYSQLI_NUM,
            Db::FETCH_BOTH => MYSQLI_BOTH,
        ];

        $rows = [];

        while ($row = $result->fetch_array(empty($columns) ? $map[$type] : MYSQLI_ASSOC)) {

            $row = self::prepare($row, $columns, $type);

            if ($fetchRow) {
                return $row;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql)
    {
        try {
            return $this->connection->query($sql);

        } catch (\mysqli_sql_exception $exception) {
            throw new QueryErrorException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchRow($sql, $columns = null, $type = Db::FETCH_NUM)
    {
        $result = $this->query($sql);

        if (is_bool($result)) {
            return [];
        }

        return self::fetch($result, $columns, $type, true);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($sql, $columns = null, $type = Db::FETCH_NUM)
    {
        $result = $this->query($sql);

        if (is_bool($result)) {
            return [];
        }

        return self::fetch($result, $columns, $type, false);
    }
}