<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowCreateTrigger extends CommandAbstract
{
    public function run(Request $request)
    {
        $name = $request['trigger'];
        $database = $request['from'];

        $trigger = $this->db->fetchRow("SHOW CREATE TRIGGER `{$database}`.`{$name}`", Db::FETCH_ASSOC);

        return ['trigger' => $name, 'from' => $database, 'statement' => $trigger['SQL Original Statement']];
    }
}