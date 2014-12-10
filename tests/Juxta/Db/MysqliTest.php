<?php

namespace Juxta\Tests\Db;

use Juxta\Db\AdapterMysqli;

class AdapterMysqliTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryWillThrowQueryExceptionOnQueryError()
    {
        $mysqli = $this->getMockBuilder('mysqli')->getMock();

        $mysqli->method('query')->will($this->throwException(new \mysqli_sql_exception()));

        $adapter = new AdapterMysqli($mysqli);

        $this->setExpectedException('Juxta\Db\Exception\QueryErrorException');

        $adapter->query('');
    }

    public function testFetchRowWillReturnEmptyArrayOnBooleanResult()
    {
        $mysqli = $this->getMockBuilder('mysqli')->getMock();

        $mysqli->method('query')->will($this->returnValue(true));

        $adapter = new AdapterMysqli($mysqli);

        $this->assertEquals($adapter->fetchRow("SELECT ..."), []);

        $this->assertEquals($adapter->fetchAll("SELECT ..."), []);
    }
}