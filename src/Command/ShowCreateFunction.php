<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowCreateFunction extends CommandAbstract
{
    public function run(Request $request)
    {
        $name = $request['function'];
        $database = $request['from'];

        $function = $this->db->fetchRow("SHOW CREATE FUNCTION `{$database}`.`{$name}`", Db::FETCH_ASSOC);

        return ['function' => $name, 'from' => $database, 'statement' => $function['Create Function']];
    }
}