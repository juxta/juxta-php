<?php

namespace Juxta\Command;

use Juxta\Db\Exception\Query;
use Juxta\Request;

class DropUsers extends CommandAbstract
{
    public function run(Request $request)
    {
        $dropped = [];

        foreach ((array)$request['users'] as $user) {
            try {
                $this->db->query("DROP USER {$user}");
                $dropped[] = $user;

            } catch (Query $exception) {
                $exception->attach(['dropped' => $dropped]);
                throw $exception;
            }
        }

        return $dropped;
    }
}