<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowEngines extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetch("SHOW ENGINES", Db::FETCH_ALL_NUM, ['Engine', 'Support', 'Comment']);
    }
}