<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowUsers extends CommandAbstract
{
    public function run(Request $request)
    {
        $rows = $this->db->fetchAll("SELECT * FROM mysql.user", Db::FETCH_ASSOC);

        return array_map([$this, 'prepareRow'], (array)$rows);
    }

    protected static function prepareRow($row)
    {
        return [
            $row['User'],
            $row['Host'],
            !empty($row['Password']) ? 'YES' : 'NO',
            $row['Grant_priv'] === 'Y' ? 'YES' : '',
            self::collectPrivileges($row)
        ];
    }

    protected static function collectPrivileges($row)
    {
        $privileges = [];

        foreach (Db::$privileges as $privilege => $title) {
            if (isset($row[$privilege]) && $row[$privilege] === 'Y') {
                $privileges[] = $title;
            }
        }

        if (count($privileges) === 0) {
            return 'USAGE';
        }

        if (count($privileges) === count(Db::$privileges)) {
            return  'ALL';
        }

        return  implode(', ', $privileges);
    }
}