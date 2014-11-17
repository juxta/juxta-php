<?php

namespace Juxta\Command;

use Juxta\Db\Db;
use Juxta\Request;

class ShowUsers extends CommandAbstract
{
    public function run(Request $request)
    {
        $rows = $this->db->fetchAll("SELECT * FROM mysql.user", Db::FETCH_ASSOC);

        if (!$rows || !is_array($rows)) {
            return;
        }

        $users = null;

        foreach ($rows as $row) {

            $user = [
                $row['User'], $row['Host'],
                !empty($row['Password']) ? 'YES' : 'NO',
                $row['Grant_priv'] === 'Y' ? 'YES' : ''
            ];

            $privileges = [];

            foreach (Db::$privileges as $privilege => $title) {
                if (isset($row[$privilege]) && $row[$privilege] === 'Y') {
                    $privileges[] = $title;
                }
            }

            if (count($privileges) === 0) {
                $privileges = 'USAGE';

            } else if (count($privileges) === count(Db::$privileges)) {
                $privileges = 'ALL';

            } else {
                $privileges = implode(', ', $privileges);
            }

            $user[] = $privileges;

            $users[] = $user;

        }

        return $users;
    }
}