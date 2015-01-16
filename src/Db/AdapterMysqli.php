<?php

namespace Juxta\Db;

use Juxta\Db\Db;
use Juxta\Db\Exception\ConnectErrorException;
use Juxta\Db\Exception\QueryErrorException;

class AdapterMysqli implements AdapterInterface
{
    /**
     * @var \mysqli
     */
    protected $connection;

    /**
     * @param array|\mysqli
     * @throws ConnectErrorException
     */
    public function __construct()
    {
        if (!function_exists('mysqli_report')) {
            throw new ConnectErrorException('The mysqli extension is not enabled');
        }

        $arguments = func_get_args();

        if (empty($arguments) || !($arguments[0] instanceof \mysqli || is_array($arguments[0]))) {
            throw new ConnectErrorException('Invalid argument');
        }

        if ($arguments[0] instanceof \mysqli) {
            $this->connection = $arguments[0];
            return;
        }

        $params = Db::extract($arguments[0]);

        mysqli_report(MYSQLI_REPORT_STRICT);

        try {

            $this->connection = new \mysqli(
                $params['host'],
                $params['user'],
                $params['password'],
                '',
                $params['port']
            );

            $this->connection->set_charset($params['charset']);

        } catch (\mysqli_sql_exception $exception) {
            throw new ConnectErrorException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function query($sql)
    {
        try {
            return $this->connection->query($sql);

        } catch (\mysqli_sql_exception $exception) {
            throw new QueryErrorException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Prepare a row
     *
     * @param array $row
     * @param array $columns
     * @param int $type
     * @return array
     */
    protected static function prepare(array $row, array $columns = null, $type = Db::FETCH_NUM)
    {
        if (empty($columns)) {
            return $row;
        }

        $values = [];

        foreach ($columns as $column) {

            if (!array_key_exists($column, $row)) {
                continue;
            }

            if ($type & Db::FETCH_NUM) {
                $values[] = $row[$column];
            }

            if ($type & Db::FETCH_ASSOC) {
                $values[$column] = $row[$column];
            }
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($sql, $type = Db::FETCH_ALL_NUM, array $columns = null)
    {

        $result = $this->query($sql);

        if (is_bool($result)) {
            return [];
        }

        $resultType = MYSQLI_NUM;

        if ($type & Db::FETCH_ASSOC) {
            $resultType = MYSQLI_ASSOC;

        } else if (!empty($columns)) {
            $resultType = MYSQLI_BOTH;
        }

        $rows = [];

        while ($row = $result->fetch_array($resultType)) {

            $row = self::prepare($row, $columns, $type);

            if ($type & Db::FETCH_ROW) {
                return $row;
            }

            $rows[] = $row;
        }

        return $rows;
    }
}