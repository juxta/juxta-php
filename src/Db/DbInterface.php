<?php

namespace Juxta\Db;

interface DbInterface
{
    public function query($sql);

    public function fetchAll($sql, $columns = null, $type = Db::FETCH_NUM);

    public function fetchRow($sql, $columns = null, $type = Db::FETCH_NUM);
}