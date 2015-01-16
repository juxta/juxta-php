<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowTables extends CommandAbstract
{
    public function run(Request $request)
    {
        $tables = $this->db->fetch(
            "SHOW TABLE STATUS FROM `{$request['from']}` WHERE `Engine` IS NOT NULL",
            Db::FETCH_ALL_NUM,
            ['Name', 'Engine', 'Rows', 'Data_length', 'Index_length']
        );

        $sumDataAndIndexLength = function($table) {
            $table[3] += $table[4];
            unset($table[4]);
            return $table;
        };

        return array_map($sumDataAndIndexLength, $tables);
    }
}