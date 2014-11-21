<?php

namespace Juxta\Command;

use Juxta\Db\Exception\QueryErrorException;
use Juxta\Request;

class DropDatabases extends CommandAbstract
{
    public function run(Request $request)
    {
        $dropped = [];

        foreach ((array)$request['databases'] as $database) {
            try {
                $this->db->query("DROP DATABASE `{$database}`");
                $dropped[] = $database;

            } catch (QueryErrorException $exception) {

                if (!empty($dropped)) {
                    $exception->attach(['dropped' => $dropped]);
                }

                throw $exception;
            }
        }

        return $dropped;
    }
}