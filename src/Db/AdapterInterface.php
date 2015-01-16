<?php

namespace Juxta\Db;

interface AdapterInterface
{
    /**
     * Run a query
     *
     * @param string $sql
     * @return mixed
     * @throws QueryErrorException
     */
    public function query($sql);

    /**
     * Run a query and fetch one or all result rows
     * @param $sql
     * @param int $type
     * @param array $columns
     * @return mixed
     */
    public function fetch($sql, $type = Db::FETCH_ALL_NUM, array $columns = null);

}