<?php

namespace Juxta\Command;

use Juxta\Request;

class ShowIndexes extends CommandAbstract
{
    public function run(Request $request)
    {
        $columns = $this->db->fetchAll(
            "SHOW INDEXES FROM {$request['from']}.{$request['table']}",
            ['Key_name', 'Index_type', 'Non_unique', 'Column_name']
        );

        $indexes = null;

        foreach ($columns as $column) {
            if (isset($indexes[$column[0]])) {
                $indexes[$column[0]][3][] = $column[3];
            } else {
                $indexes[$column[0]] = $column;
                $indexes[$column[0]][3] = (array)$indexes[$column[0]][3];
            }
        }

        if (is_array($indexes)) {
            $indexes = array_values($indexes);
        }

        return $indexes;
    }
}