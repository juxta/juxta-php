<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowTriggers extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW TRIGGERS FROM `{$request['from']}`", ['Trigger', 'Event', 'Timing', 'Table']);
    }
}