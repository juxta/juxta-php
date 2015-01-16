<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowDatabaseProperties extends CommandAbstract
{
    public function run(Request $request)
    {
        $database = $request['database'];

        $properties = array('name' => $database);

        $sql1 = "SELECT `DEFAULT_CHARACTER_SET_NAME` as `name`, "
            . "`DEFAULT_COLLATION_NAME` as `collation` "
            . "FROM `information_schema`.`SCHEMATA` "
            . "WHERE `SCHEMA_NAME` = '{$database}'";

        $charset = $this->db->fetch($sql1, Db::FETCH_ALL_BOTH);

        if ($charset) {
            $properties['charset'] = $charset[0]['name'];
            $properties['collation'] = $charset[0]['collation'];
        }

        $sql2 = "SELECT COUNT(*) AS `tables`, SUM(`TABLE_ROWS`) AS `rows`, "
            . "SUM(`DATA_LENGTH`) AS `data_length`, "
            . "SUM(`INDEX_LENGTH`) AS `index_length` "
            . "FROM `INFORMATION_SCHEMA`.`TABLES` "
            . "WHERE `TABLE_SCHEMA` = '{$database}' AND `TABLE_TYPE` <> 'VIEW'";

        $statistics = $this->db->fetch($sql2, Db::FETCH_ALL_BOTH);

        if ($statistics) {
            $properties['tables'] = $statistics[0]['tables'];
            $properties['rows'] = $statistics[0]['rows'];
            $properties['data_length'] = (int)$statistics[0]['data_length'];
            $properties['index_length'] = (int)$statistics[0]['index_length'];
        }

        return $properties;
    }
}