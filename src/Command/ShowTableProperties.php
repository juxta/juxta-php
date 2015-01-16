<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowTableProperties extends CommandAbstract
{
    public function run(Request $request)
    {
        $properties = $this->db->fetch(
            "SHOW TABLE STATUS FROM `{$request['from']}` LIKE '{$request['table']}'",
            Db::FETCH_ROW_ASSOC
        );

        if (!empty($properties)) {
            $properties = array_change_key_case($properties, CASE_LOWER);
        }

        return $properties;
    }
}