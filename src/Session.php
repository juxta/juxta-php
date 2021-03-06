<?php

namespace Juxta;

final class Session
{
    public function __construct()
    {
        session_start();
    }

    /**
     * Return connections from session
     *
     * @return array
     */
    public function getConnections()
    {
        return isset($_SESSION['connections']) ? $_SESSION['connections'] : null;
    }

    /**
     * Save connection to session
     *
     * @param array $connection
     */
    public function saveConnection(array $connection)
    {
        $_SESSION['connections'][] = $connection;
    }

    /**
     * Delete connection from session
     *
     * @param int $cid
     * @return bool
     */
    public function deleteConnection($cid)
    {
        foreach ($_SESSION['connections'] as $id => $connection) {
            if ($connection['cid'] === $cid) {
                unset($_SESSION['connections'][$id]);

                return true;
            }
        }

        return false;
    }

    /**
     * Delete all connections
     *
     * @return bool
     */
    public function deleteConnections()
    {
        unset($_SESSION['connections']);

        return true;
    }
}