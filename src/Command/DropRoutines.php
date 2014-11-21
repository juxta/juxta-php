<?php

namespace Juxta\Command;

use Juxta\Db\Exception\QueryErrorException;
use Juxta\Request;

class DropRoutines extends CommandAbstract
{
    public function run(Request $request)
    {
        $database = $request['from'];

        $dropped = [];

        if (isset($request['function'])) {
            foreach ((array)$request['function'] as $function) {
                try {
                    $this->db->query("DROP FUNCTION `{$database}`.`{$function}`");
                    $dropped['function'][] = $function;

                } catch (QueryErrorException $e) {
                    $e->attach(array('dropped' => $dropped, 'from' => $database));
                    throw $e;
                }
            }
        }

        if (isset($request['procedure'])) {
            foreach ((array)$request['procedure'] as $procedure) {
                try {
                    $this->db->query("DROP PROCEDURE `{$database}`.`{$procedure}`");
                    $dropped['procedure'][] = $procedure;

                } catch (QueryErrorException $e) {
                    $e->attach(array('dropped' => $dropped, 'from' => $database));
                    throw $e;
                }
            }
        }

        return $dropped;
    }
}