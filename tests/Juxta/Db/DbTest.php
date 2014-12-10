<?php

namespace Juxta\Tests\Db;

use Juxta\Db\Db;

class DbTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $mysqli = $this->getMockBuilder('mysqli')->getMock();

        $adapter = Db::factory($mysqli, Db::EXTENSION_MYSQLI);

        $this->assertInstanceOf('\Juxta\Db\AdapterMysqli', $adapter);
    }
}