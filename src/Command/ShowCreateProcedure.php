<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowCreateProcedure extends CommandAbstract
{
    public function run(Request $request)
    {
        $name = $request['procedure'];
        $database = $request['from'];

        $procedure = $this->db->fetch("SHOW CREATE PROCEDURE `{$database}`.`{$name}`", Db::FETCH_ROW_ASSOC);

        return ['procedure' => $name, 'from' => $database, 'statement' => $procedure['Create Procedure']];
    }
}