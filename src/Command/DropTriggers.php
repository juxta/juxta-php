<?php

namespace Juxta\Command;

use Juxta\Db\Exception\QueryErrorException;
use Juxta\Request;

class DropTriggers extends CommandAbstract
{
    public function run(Request $request)
    {
        $dropped = [];

        foreach ((array)$request['triggers'] as $trigger) {
            try {
                $this->db->query("DROP TRIGGER `{$request['from']}`.`{$trigger}`");
                $dropped[] = $trigger;

            } catch (QueryErrorException $exception) {
                $exception->attach(['dropped' => $dropped]);
                throw $exception;
            }
        }

        return $dropped;
    }
}