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
     * Run a query and fetch a result row
     *
     * @param string $sql
     * @param array $columns
     * @param int $type
     * @return array
     */
    public function fetchRow($sql, $columns = null, $type = Db::FETCH_NUM);

    /**
     * Run a query and fetch all result rows
     *
     * @param string $sql
     * @param array $columns
     * @param int $type
     * @return array
     */
    public function fetchAll($sql, $columns = null, $type = Db::FETCH_NUM);
}