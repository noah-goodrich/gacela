<?php
namespace Gacela\Field;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-09-26 at 05:03:23.
 */
class TimeTest extends \PHPUnit_Framework_TestCase
{

    protected $meta;

	/**
	 * @var Time
	 */
	protected $object;

	protected function _meta()
	{
		$not_null = (object) array
		(
			'type' => 'time',
			'null' => false
		);

		$null = clone $not_null;

		$null->null = true;

		return array($not_null, $null);
	}

	protected function setUp()
	{
		$this->object = new Time;
	}

	public function providerInvalidFormat()
	{
		list($not_null, $null) = $this->_meta();

		return array(
			array($not_null, time(), false),
			array($null, new \DateTime(), false)
		);
	}

	public function providerInvalidTime()
	{
		list($not, $null) = $this->_meta();

		return array(
			array($not, '25:00:00', false),
			array($null, '23:75:00', true),
			array($not, '12:30:90', false)
		);
	}

	public function providerNull()
	{
		list($not, $null) = $this->_meta();

		return array(
			array($not, null, false)
		);
	}

	public function providerPass()
	{
		list($not_null, $null) = $this->_meta();

		return array(
			array($null, '20:00:00', true),
			array($not_null, '15:00:00', false),
			array($null, null, false)
		);
	}

	public function providerTransform()
	{
		return array_merge($this->providerPass(), $this->providerInvalidFormat(), $this->providerInvalidTime(), $this->providerNull());
	}

    /**
     * @covers Gacela\Field\Time::validate
     * @dataProvider providerPass
     */
    public function testValidatePass($meta, $value, $in)
    {
		$this->assertTrue($this->object->validate($meta, $value));
    }

	/**
	 * @param $meta
	 * @param $value
	 * @param $in
	 * @covers Gacela\Field\Time::validate
	 * @dataProvider providerInvalidFormat
	 */
	public function testValidateInvalidFormat($meta, $value, $in)
	{
		$this->assertEquals(Time::FORMAT_CODE, $this->object->validate($meta, $value));
	}

	/**
	 * @param $meta
	 * @param $value
	 * @param $in
	 * @covers Gacela\Field\Time::validate
	 * @dataProvider providerInvalidTime
	 */
	public function testValidateInvalidTime($meta, $value, $in)
	{
		$this->assertEquals(Time::TIME_CODE, $this->object->validate($meta, $value));
	}

	/**
	 * @covers Gacela\Field\Time::validate
	 * @dataProvider providerNull
	 */
	public function testValidateNull($meta, $value, $in)
	{
		$this->assertEquals(Time::NULL_CODE, $this->object->validate($meta, $value));
	}

	/**
     * @covers Gacela\Field\Time::transform
     * @dataProvider providerTransform
     */
    public function testTransform($meta, $value, $in)
    {
		$this->assertSame($value, $this->object->transform($meta, $value, $in));
    }
}
