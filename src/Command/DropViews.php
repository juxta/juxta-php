<?php

namespace Juxta\Command;

use Juxta\Db\Exception\QueryErrorException;
use Juxta\Request;

class DropViews extends CommandAbstract
{
    public function run(Request $request)
    {
        $dropped = [];

        foreach ((array)$request['views'] as $view) {
            try {
                $this->db->query("DROP VIEW `{$request['from']}`.`{$view}`;");
                $dropped[] = $view;

            } catch (QueryErrorException $exception) {
                $exception->attach(['dropped' => $dropped, 'from' => $request['from']]);
                throw $exception;
            }
        }

        return $dropped;
    }
}