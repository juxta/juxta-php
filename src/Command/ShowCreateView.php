<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowCreateView extends CommandAbstract
{
    public function run(Request $request)
    {
        $view = $request['view'];
        $database = $request['from'];

        $view = $this->db->fetch("SHOW CREATE VIEW `{$database}`.`{$view}`", Db::FETCH_ROW_ASSOC);

        return ['view' => $view, 'from' => $database, 'statement' => $view['Create View']];
    }
}