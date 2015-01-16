<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowForeign extends CommandAbstract
{
    public function run(Request $request)
    {
        $sql = <<<SQL
SELECT
  kcu.CONSTRAINT_NAME,
  kcu.COLUMN_NAME,
  CONCAT(kcu.REFERENCED_TABLE_NAME, '.', kcu.REFERENCED_COLUMN_NAME),
  rc.UPDATE_RULE,
  rc.DELETE_RULE
FROM information_schema.KEY_COLUMN_USAGE kcu
JOIN information_schema.REFERENTIAL_CONSTRAINTS rc
  ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
WHERE
  kcu.TABLE_SCHEMA  = '{$request['from']}'
  AND kcu.TABLE_NAME = '{$request['table']}'
  AND kcu.CONSTRAINT_NAME <> 'PRIMARY'
SQL;

        return $this->db->fetch($sql, Db::FETCH_ALL_NUM);
    }
}