<?php

namespace Juxta;

use Juxta\Db\Connection;
use Juxta\Db\Db;

final class Connections
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Session $session
     * @param Config $config
     */
    public function __construct(Session $session, Config $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * @param bool $mask
     * @return array|null
     */
    public function getAll($mask = true)
    {
        $stored = array();
        $established = array();

        if (!empty($this->config['connections'])) {
            foreach ($this->config['connections'] as $connection) {
                $stored[Db::key($connection)] = $connection;
            }
        }

        foreach ((array)$this->session->getConnections() as $connection) {
            $established[Db::key($connection)] = $connection;
        }

        $connections = array_merge($stored, $established);

        ksort($connections);

        if ($mask) {
            $connections = array_map(array('Juxta\Db\Db', 'maskPassword'), $connections);
        }

        return !empty($connections) ? $connections : null;
    }

    /**
     * @param $key
     * @param bool $mask
     * @return array|null
     */
    public function getByKey($key, $mask = false)
    {
        $connections = $this->getAll($mask);

        if (isset($connections[$key])) {
            return $connections[$key];
        }
    }

    /**
     * Return connection with Connection ID
     *
     * @param $cid
     * @param bool $mask
     * @return array|null
     */
    public function getByCid($cid, $mask = false)
    {
        $connection = array_filter((array)$this->getAll($mask), function ($c) use ($cid) {
            return isset($c['cid']) && $c['cid'] == $cid;
        });

        return $connection ? reset($connection) : null;
    }

    /**
     * @param array $connection
     * @return array
     */
    public function save(array $connection)
    {
        $cid = array_reduce((array)$this->getAll(), function ($cid, $connection) {
                return max($cid, isset($connection['cid']) ? $connection['cid'] : -1);
            }, -1) + 1;

        $connection = array('cid' => $cid) + $connection;

        $this->session->saveConnection($connection);

        return $connection;
    }

    /**
     * @param $cid
     * @return bool
     */
    public function delete($cid)
    {
        return $this->session->deleteConnection($cid);
    }

    /**
     * @return bool
     */
    public function deleteAll()
    {
        $this->session->deleteConnections();
    }
}