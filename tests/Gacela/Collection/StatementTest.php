<?php
namespace Gacela\Collection;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-10-23 at 08:26:51.
 */
class StatementTest extends \Test\GUnit\Extensions\Database\TestCase
{
    /**
     * @var Statement
     */
    protected $collection;

	/**
	 * @var \Gacela\DataSource\Database
	 */
	protected $source;

	protected function getDataSet()
	{
		return $this->createArrayDataSet(
			array(
				'tests' => array(
					array('testName' => 1),
					array('testName' => 2),
					array('testName' => 3),
					array('testName' => 4),
					array('testName' => 5),
					array('testName' => 6),
					array('testName' => 7)
				)
			)
		);
	}

	protected function setUp()
	{
		parent::setUp();

		$this->source = \Gacela::instance()->getDataSource('test');

		$data = $this->source->query($this->source->loadResource('tests'), "SELECT * FROM tests");

		$this->collection = new Statement(\Gacela::instance()->loadMapper('test'), $data);
	}

	/**
	 * @covers \Gacela\Collection\Collection::__construct
	 */
	public function test__construct()
	{
		$this->assertAttributeInstanceOf('\Test\Mapper\Test', '_mapper', $this->collection);

		$this->assertAttributeInstanceOf('PDOStatement', '_data', $this->collection);
	}

	public function testAsArrayOneField()
	{
		$this->assertSame(array(1,2,3,4,5,6,7), $this->collection->asArray('id'));
	}

	public function testAsArrayMultipleFields()
	{
		$arr2 = array(
			array('testName' => '1', 'flagged' => false),
			array('testName' => '2', 'flagged' => false),
			array('testName' => '3', 'flagged' => false),
			array('testName' => '4', 'flagged' => false),
			array('testName' => '5', 'flagged' => false),
			array('testName' => '6', 'flagged' => false),
			array('testName' => '7', 'flagged' => false)
		);

		$this->assertSame($arr2, $this->collection->asArray('testName', 'flagged'));
	}

    /**
     * @covers Gacela\Collection\Statement::count
     */
    public function testCount()
    {
		$this->assertSame(7, count($this->collection));
    }

    /**
     * @covers Gacela\Collection\Statement::current
     */
    public function testCurrentInstance()
    {
		$current = $this->collection->current();

		$this->assertInstanceOf('Test\Model\Test', $current);
		$this->assertEquals(1, $current->id);
    }

	public function testCurrentIsFirstElementInArray()
	{
		$current = $this->collection->current();
		$this->assertEquals(1, $current->id);
	}

	public function testCurrentNotAdvancesPointer()
	{
		$current = $this->collection->current();
		$this->assertEquals($current, $this->collection->current());
	}

	public function testCurrentFindByPrimaryKey()
	{
		$data = $this->source->query($this->source->loadResource('tests'), 'SELECT id FROM tests WHERE id > 2');

		$arr = new Statement(\Gacela::instance()->loadMapper('test'), $data);

		$this->assertSame('3', $arr->current()->testName);
	}

	public function testCurrentLoad()
	{
		$data = $this->source->query($this->source->loadResource('tests'), "SELECT * FROM tests WHERE testName = '6'");

		$collection = new Statement(\Gacela::instance()->loadMapper('test'), $data);

		$current = $collection->current();

		$this->assertSame(6, $current->id);
		$this->assertSame('6', $current->testName);
	}

	public function testCurrentInvalidIndexReturnsEmptyInstance()
	{
		$data = $this->source->query($this->source->loadResource('tests'), 'SELECT * FROM tests WHERE id < 1');

		$collection = new Statement(\Gacela::instance()->loadMapper('test'), $data);

		$current = $collection->current();

		$this->assertInstanceOf('\Test\Model\Test', $current);
		$this->assertSame(null, $current->id);
	}

    /**
     * @covers Gacela\Collection\Statement::key
     */
    public function testKey()
    {
        $this->assertSame(0, $this->collection->key());

		foreach($this->collection as $obj) {}

		$this->assertSame(7, $this->collection->key());
    }

	/**
	 * @covers Gacela\Collection\Statement::next
	 */
	public function testNext()
	{
		$this->collection->next();

		$this->assertSame(1, $this->collection->key());
		$this->assertEquals('2', $this->collection->current()->testName);
	}

    /**
     * @covers Gacela\Collection\Statement::rewind
     */
    public function testRewind()
    {
		$this->assertSame(1, $this->collection->current()->id);
		$this->assertSame(0, $this->collection->key());

		foreach($this->collection as $obj) {}

		$this->assertNull($this->collection->current()->id);
		$this->assertSame(7, $this->collection->key());

		$this->collection->rewind();

		$this->assertSame(1, $this->collection->current()->id);
		$this->assertSame(0, $this->collection->key());
    }

    /**
     * @covers Gacela\Collection\Statement::search
     * @todo   Implement testSearch().
     */
    public function testSearch()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

	/**
	 * @covers Gacela\Collection\Statement::seek
	 */
	public function testSeek()
	{
		$this->collection->seek(4);

		$this->assertSame('5', $this->collection->current()->testName);
		$this->assertSame(4, $this->collection->key());
	}

	/**
	 * @expectedException \OutOfBoundsException
	 */
	public function testSeekOutOfBoundsException()
	{
		$this->collection->seek(8);
	}

    /**
     * @covers Gacela\Collection\Statement::slice
     * @todo   Implement testSlice().
     */
    public function testSlice()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Collection\Statement::valid
     */
    public function testValid()
    {
        foreach($this->collection as $obj) {
			if($this->collection->key() < 7) {
				$this->assertTrue($this->collection->valid());
			} else {
				$this->assertFalse($this->collection->valid());
			}
		}
    }

	public function testIterateStatementMultipleTimes()
	{
		for($i=0;$i<100;$i++) {
			foreach($this->collection as $k => $row) {
				$this->assertSame($k+1, $row->id);
			}

			unset($row);
		}
	}

	public function testTwoActiveStatementsAtOneTime()
	{
		$one = new Statement(
			\Gacela::instance()->loadMapper('test'),
			$this->source->query($this->source->loadResource('tests'), "SELECT * FROM tests")
		);

		$two = new Statement(
			\Gacela::instance()->loadMapper('customer'),
			$this->source->query($this->source->loadResource('customers'), 'SELECT * FROM customers INNER JOIN users ON customers.id = users.id')
		);

		foreach($one as $key => $row) {
			$this->assertSame($key+1, $row->id);
		}

		foreach($two as $t => $o) {}

		foreach($one as $k => $r) {
			$this->assertSame($k+1, $r->id);
		}
	}

	public function testEmptyCollection()
	{
		$data = $this->source->query($this->source->loadResource('tests'), "SELECT * FROM tests WHERE id < 0");

		$collection = new Statement(\Gacela::instance()->loadMapper('test'), $data);

		foreach($collection as $row)
		{
			$this->fail('Empty Collection should not iterate');
		}
	}
}
