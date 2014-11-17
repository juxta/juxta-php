<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowTables extends CommandAbstract
{
    public function run(Request $request)
    {
        $tables = $this->db->fetchAll(
            "SHOW TABLE STATUS FROM `{$request['from']}` WHERE `Engine` IS NOT NULL",
            ['Name', 'Engine', 'Rows', 'Data_length', 'Index_length']
        );

        if (!empty($tables)) {
            $tables = array_map(
                function ($table) {
                    $table[3] += $table[4];
                    unset($table[4]);
                    return $table;
                },
                $tables
            );
        }

        return $tables;
    }
}