<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowCharsets extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW CHARSET", ['Charset', 'Default collation', 'Description']);
    }
}