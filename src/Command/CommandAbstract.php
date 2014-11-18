<?php

namespace Juxta\Command;

use Juxta\Db\DbInterface;

abstract class CommandAbstract implements CommandInterface
{
    /**
     * @var DbInterface
     */
    protected $db;

    /**
     * @param DbInterface $db
     */
    public function __construct(DbInterface $db)
    {
        $this->db = $db;
    }
}