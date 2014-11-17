<?php

namespace Juxta\Command;

use Juxta\Request;

class CreateDatabase extends CommandAbstract
{
    public function run(Request $request)
    {
        return $this->db->query("CREATE DATABASE `{$request['name']}`");
    }
}