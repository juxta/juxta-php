<?php

namespace Juxta\Command;

use Juxta\Db\DbInterface;

abstract class CommandAbstract implements CommandInterface
{
    protected $_db;

    public function __construct(DbInterface $db)
    {
        $this->db = $db;
    }
}