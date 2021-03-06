<?php

namespace Gacela\DataSource\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-10-01 at 06:58:20.
 */
class SalesforceTest extends \Test\GUnit\Extensions\Database\TestCase
{
    /**
     * @var Salesforce
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
	{
		parent::setUp();

		$sf = \Gacela::instance()->getDatasource('sf');

		$adapter = new \ReflectionProperty($sf, '_adapter');

		$adapter->setAccessible(true);

		$this->object = $adapter->getValue($sf);	
    }

    /**
     * @covers Gacela\DataSource\Adapter\Salesforce::load
     */
    public function testLoadGuid()
    {
		$meta = $this->object->load('Account');
	
		$id = $meta['columns']['Id'];

		$this->assertAttributeEquals('guid', 'type', $id);
		$this->assertAttributeSame(true, 'primary', $id);
		$this->assertAttributeSame(18, 'length', $id);
		$this->assertAttributeSame(false, 'default', $id);
	}
}
