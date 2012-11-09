<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-10-11 at 04:36:16.
 */
class ModelTest extends DbTestCase
{
    /**
     * @var \Test\Model\User
     */
    protected $object;

	/**
	 * @var Gacela
	 */
	protected $gacela;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$data = (object) array();

		$this->gacela = Gacela::instance();

        $this->object = new Test\Model\Test($this->gacela, new Test\Mapper\Test($this->gacela), $data);
    }

	/**
	 * @covers Gacela\Model\Model::__construct
	 */
	public function test__constructDefaultValues()
	{
		$this->assertSame(null, $this->object->id);
		$this->assertSame(null, $this->object->testName);
		$this->assertInternalType('int', $this->object->started);
		$this->assertSame(null, $this->object->completed);
		$this->assertSame(false, $this->object->flagged);
	}

	public function test__constructExtraFields()
	{
		$data = array(
			'wizardId' => null,
			'is_admin' => false,
			'role' => 'teacher',
			'affiliate' => 'gacela',
			'fname' => 'Test',
			'lname' => 'Last',
			'addressId' => 3,
			'locationName' => 'Location',
			'phone' => 1236549878
		);

		$this->object = new App\Model\Wizard($this->gacela, new App\Mapper\Wizard($this->gacela), $data);

		$this->assertAttributeEquals((object) $data, '_data', $this->object);
	}

    /**
     * @covers Gacela\Model\Model::__get
     * @todo   Implement test__get().
     */
    public function test__get()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::__isset
     * @todo   Implement test__isset().
     */
    public function test__isset()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::__set
     * @todo   Implement test__set().
     */
    public function test__set()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::add
     * @todo   Implement testAdd().
     */
    public function testAdd()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::delete
     * @todo   Implement testDelete().
     */
    public function testDelete()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::init
     * @todo   Implement testInit().
     */
    public function testInit()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::remove
     * @todo   Implement testRemove().
     */
    public function testRemove()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::save
     * @todo   Implement testSave().
     */
    public function testSave()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::setData
     * @todo   Implement testSetData().
     */
    public function testSetData()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Gacela\Model\Model::validate
     * @todo   Implement testValidate().
     */
    public function testValidateEmptyObjectWithDefaults()
    {
		$this->object->testName = 'Test';

		$this->assertTrue($this->object->validate(), 'Errors: '.print_r($this->object->errors, true));
    }
}
