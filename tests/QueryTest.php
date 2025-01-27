<?php
namespace Aura\Uri;

use PHPUnit\Framework\TestCase;

/**
 * Test class for Query.
 * Generated by PHPUnit on 2012-07-21 at 15:45:19.
 */
class QueryTest extends TestCase
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->query = new Query;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown() : void
    {
        parent::tearDown();
    }

    /**
     * @covers Query::__toString
     */
    public function test__toString()
    {
        $query_string = 'foo=bar&baz=dib';
        $this->query->setFromString($query_string);
        $actual = $this->query->__toString();
        $this->assertEquals($actual, $query_string);
    }

    /**
     * @covers Query::setFromString
     */
    public function testSetFromString()
    {
        $query_string = 'foo=bar&baz=dib';
        $this->query->setFromString($query_string);
        $actual = $this->query->getArrayCopy();
        $expected = [
            'foo' => 'bar',
            'baz' => 'dib',
        ];
        $this->assertEquals($actual, $expected);
    }
    
    public function test_deepArrays()
    {
        $query_string = 'foo[bar]=baz&zim[gir]=dib';
        $this->query->setFromString($query_string);
        $expect = 'foo%5Bbar%5D=baz&zim%5Bgir%5D=dib';
        $actual = $this->query->__toString();
        $this->assertEquals($expect, $actual);
    }

    public function testSetQueryString()
    {
        $query_string = 'foo=bar&baz=dib';
        $this->query->setFromString($query_string);
        $this->query->offsetSet('foo', 'another');
        $this->query->offsetUnset('baz');
        $this->query->page = 1;
        $this->query['limit'] = 50;
        $actual = $this->query->getArrayCopy();
        $expected = [
            'foo' => 'another',
            'page' => 1,
            'limit' => 50,
        ];
        $this->assertEquals($actual, $expected);
        $expect = 'foo=another&page=1&limit=50';
        $actual = $this->query->__toString();
        $this->assertEquals($expect, $actual);
    }
}
