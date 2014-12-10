<?php

namespace Juxta\Command;

use Juxta\Db\AdapterInterface;

abstract class CommandAbstract implements CommandInterface
{
    /**
     * @var AdapterInterface
     */
    protected $db;

    /**
     * @param AdapterInterface $db
     */
    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
    }
}