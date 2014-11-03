<?php

namespace Juxta\Db;

class Connection
{
    /**
     * Extract connection parameters from array
     *
     * @param $array
     * @return array
     */
    public static function extract($array)
    {
        $connection = array_intersect_key($array, array_flip(array('host', 'port', 'user', 'password', 'charset')));

        if (array_key_exists('host', $connection)) {
            $connection['host'] = trim($connection['host']);
        }

        if (empty($connection['host'])) {
            $connection['host'] = Db::DEFAULT_HOST;
        }

        if (array_key_exists('port', $connection)) {
            $connection['port'] = (int)$connection['port'];
        }

        if (empty($connection['port'])) {
            $connection['port'] = Db::DEFAULT_PORT;
        }

        if (empty($connection['charset'])) {
            $connection['charset'] = Db::DEFAULT_CHARSET;
        }

        if (empty($connection['user'])) {
            unset($connection['user']);
        }

        if (empty($connection['password'])) {
            unset($connection['password']);
        }

        return $connection;
    }

    /**
     * Compose connection key
     *
     * @param array $connection
     * @return string
     */
    public static function key(array $connection)
    {
        $key = isset($connection['user']) ? $connection['user'] : '';

        $key .= '@';

        $key .= isset($connection['host']) ? $connection['host'] : Db::DEFAULT_HOST;

        $key .= ':';

        $key .= isset($connection['port']) ? $connection['port'] : Db::DEFAULT_PORT;

        return $key;
    }

    /**
     * @param array $connection
     * @return array
     */
    public static function maskPassword(array $connection)
    {
        if (isset($connection['password'])) {
            if (isset($connection['cid'])) {
                unset($connection['password']);

            } else {
                $connection['password'] = true;
            }
        }

        return $connection;
    }
}