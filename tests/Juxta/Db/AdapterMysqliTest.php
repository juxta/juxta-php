<?php

namespace Juxta\Tests\Db;

use Juxta\Db\AdapterMysqli;
use Juxta\Db\Db;

class AdapterMysqliTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mysqli = $this->getMockBuilder('mysqli')->getMock();

        $this->adapter = new AdapterMysqli($this->mysqli);
    }

    public function testQueryWillThrowQueryExceptionOnQueryError()
    {
        $this->mysqli->method('query')->will($this->throwException(new \mysqli_sql_exception()));

        $this->setExpectedException('Juxta\Db\Exception\QueryErrorException');

        $this->adapter->query('');
    }

    public function testFetchRowWillReturnEmptyArrayOnBooleanResult()
    {
        $this->mysqli->method('query')->will($this->returnValue(true));

        $this->assertEquals($this->adapter->fetch("SELECT ..."), []);
    }

    public function Q()
    {
        return [
            [
                Db::FETCH_ALL_NUM,
                [
                    ['actor', 'InnoDB', 200, 32768],
                    ['address', 'InnoDB', 549, 96],
                ],
                null,
                MYSQLI_NUM,
                [
                    ['actor', 'InnoDB', 200, 32768],
                    ['address', 'InnoDB', 549, 96],
                ]
            ],
            [
                Db::FETCH_ALL_ASSOC,
                [
                    ['name' => 'actor', 'engine' => 'InnoDB', 'rows' => 200, 'size' => 32768],
                    ['name' => 'address', 'engine' => 'InnoDB', 'rows' => 549, 'size' => 96],
                ],
                null,
                MYSQLI_ASSOC,
                [
                    ['name' => 'actor', 'engine' => 'InnoDB', 'rows' => 200, 'size' => 32768],
                    ['name' => 'address', 'engine' => 'InnoDB', 'rows' => 549, 'size' => 96],
                ]
            ],
            [
                Db::FETCH_ROW_BOTH,
                [
                    ['name' => 'actor', 'engine' => 'InnoDB', 'rows' => 200, 'size' => 32768],
                ],
                ['name', 'engine'],
                MYSQLI_ASSOC,
                [0 => 'actor', 'name' => 'actor', 1 => 'InnoDB', 'engine' => 'InnoDB'],
            ],
        ];
    }

    /**
     * @dataProvider Q
     */
    public function testDefaultFetch($type, $mysqlFetchArrayResult, $columns, $mysqlExpectedResultType, $expectedResult)
    {
        $result = $this->getMockBuilder('mysqli_result')->disableOriginalConstructor()->getMock();

        foreach ($mysqlFetchArrayResult as $n => $q) {
            $result
                ->expects($this->at($n))
                ->method('fetch_array')
                ->with($this->equalTo($mysqlExpectedResultType))
                ->will($this->returnValue($q));
        }

        $this->mysqli->method('query')->will($this->returnValue($result));

        $z = $this->adapter->fetch("SELECT ..", $type, $columns);

        $this->assertEquals($z, $expectedResult);
    }


}