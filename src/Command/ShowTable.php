<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowTable extends CommandAbstract
{
    public function run(Request $request)
    {
        $table = $this->db->fetch(
            "SHOW COLUMNS FROM `{$request['table']}` FROM `{$request['from']}`",
            Db::FETCH_ALL_NUM
        );

        if (!$table || !is_array($table)) {
            return;
        }

        $columns = [];

        while (list($field, $type, $isNull, $key, $default, $extra) = current($table)) {
            // Name
            $column = [$field];

            // type
            $column[] = trim(preg_replace('/unsigned|zerofill/', '', $type));

            // in_null
            $column[] = $isNull;

            // attributes
            preg_match_all('/unsigned|zerofill/', $type, $matches);
            if (!empty($matches[0])) {
                $column[] = $matches[0];
            } else {
                $column[] = null;
            }

            // default
            $column[] = $default;

            // options
            $options = null;
            if ($key === 'PRI') {
                $options[] = 'primary';
            }
            if (preg_match('/auto_increment/', $extra)) {
                $options[] = 'auto_increment';
            }
            if (preg_match('/on update CURRENT_TIMESTAMP/', $extra)) {
                $options[] = 'on update current_timestamp';
            }
            $column[] = $options;

            $columns[] = $column;

            next($table);
        }

        return [
            'content' => ['column', 'type', 'is_null', 'attributes', 'default', 'options'],
            'from' => $request['from'],
            'columns' => $columns,
            'table' => $table,
        ];
    }
}