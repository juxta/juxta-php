<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class Browse extends CommandAbstract
{
    public function run(Request $request)
    {
        $table = $request['browse'];
        $database = $request['from'];
        $limit = (int)$request->get('limit', 30);
        $offset = (int)$request->get('offset', 0);

        $data = $this->db->fetch("SELECT * FROM `{$database}`.`{$table}` LIMIT {$offset}, {$limit}", Db::FETCH_ALL_NUM);

        $columns = $this->db->fetch(
            "SHOW COLUMNS IN `{$table}` FROM `{$database}`",
            Db::FETCH_ALL_NUM,
            ['Field', 'Key', 'Type']
        );

        $total = $this->db->fetch("SELECT COUNT(*) AS `count` FROM `{$database}`.`{$table}`", Db::FETCH_ROW_ASSOC);

        return ['data' => $data, 'columns' => $columns, 'total' => $total['count']];
    }
}