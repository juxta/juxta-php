<?php

namespace Juxta\Command;

use Juxta\Db\Exception\QueryErrorException;
use Juxta\Request;

class TruncateTables extends CommandAbstract
{
    public function run(Request $request)
    {
        $truncated = [];

        foreach ((array)$request['tables'] as $table) {
            try {
                $this->db->query("TRUNCATE TABLE `{$request['from']}`.`{$table}`;");
                $truncated[] = $table;

            } catch (QueryErrorException $exception) {
                $exception->attach(['truncated' => $truncated, 'from' => $request['from']]);
                throw $exception;
            }
        }

        return $truncated;
    }
}