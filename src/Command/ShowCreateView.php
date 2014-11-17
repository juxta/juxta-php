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

        $view = $this->db->fetchAll("SHOW CREATE VIEW `{$database}`.`{$view}`", true, Db::FETCH_ASSOC);

        return ['view' => $view, 'from' => $database, 'statement' => $view[0]['Create View']];
    }
}