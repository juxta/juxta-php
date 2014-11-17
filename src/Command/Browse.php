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

        $data = $this->db->fetchAll("SELECT * FROM `{$database}`.`{$table}` LIMIT {$offset}, {$limit}");

        $columns = $this->db->fetchAll("SHOW COLUMNS IN `{$table}` FROM `{$database}`", ['Field', 'Key', 'Type']);

        $total = $this->db->fetchRow("SELECT COUNT(*) AS `count` FROM `{$database}`.`{$table}`", Db::FETCH_ASSOC);

        return ['data' => $data, 'columns' => $columns, 'total' => $total['count']];
    }
}