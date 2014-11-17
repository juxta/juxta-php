<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowEngines extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->fetchAll("SHOW ENGINES", ['Engine', 'Support', 'Comment']);
    }
}