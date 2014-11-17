<?php

namespace Juxta\Command;

use Juxta\Request;

class Kill extends CommandAbstract
{
    public function run(Request $request)
    {
        $killed = [];

        foreach ((array)$request['processes'] as $process) {
            try {
                $this->db->query("KILL {$process}");
                $killed[] = $process;

            } catch (Query $exception) {
                $exception->attach(['killed' => $killed]);
                throw $exception;
            }
        }

        return $killed;
    }
}