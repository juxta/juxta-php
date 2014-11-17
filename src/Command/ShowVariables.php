<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowVariables extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW VARIABLES", ['Variable_name', 'Value']);
    }
}