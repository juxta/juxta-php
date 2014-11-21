<?php

namespace Juxta\Command;

use Juxta\Db\Exception\QueryErrorException;
use Juxta\Request;

class DropTables extends CommandAbstract
{
    public function run(Request $request)
    {
        $dropped = [];

        foreach ((array)$request['tables'] as $table) {
            try {
                $this->db->query("DROP TABLE `{$request['from']}`.`{$table}`;");
                $dropped[] = $table;

            } catch (QueryErrorException $exception) {
                $exception->attach(['dropped' => $dropped, 'from' => $request['from']]);
                throw $exception;
            }
        }

        return $dropped;
    }
}