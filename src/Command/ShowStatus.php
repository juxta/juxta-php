<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowStatus extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW STATUS", ['Variable_name', 'Value']);
    }
}