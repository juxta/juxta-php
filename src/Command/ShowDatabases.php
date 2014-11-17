<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowDatabases extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW DATABASES", ['Database']);
    }
}