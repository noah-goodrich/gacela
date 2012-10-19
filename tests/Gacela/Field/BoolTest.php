<?php
namespace Gacela\Field;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-09-30 at 06:30:02.
 */
class BoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \stdClass
     */
    protected $meta;

	/**
	 * @var Bool
	 */
	protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$this->object = new Bool;

        $this->meta = (object) array(
			'null' => false,
			'type' => 'bool'
		);
    }

	public function provider()
	{
		return array(
			array('0', 0, false),
			array('1', 1, true),
			array(0, 0, false),
			array(false, 0, false),
			array(1, 1, true),
			array(true, 1, true)
		);
	}

	public function providerPass()
	{
		return array(
			array(true),
			array(false)
		);
	}

	public function providerTypeCode()
	{
		return array(
			array('String'),
			array(2),
			array(-1),
			array(0xF),
			array(0),
			array(1)
		);
	}

    /**
     * @covers Gacela\Field\Bool::validate
	 *
     */
    public function testValidateNullCode()
    {
		$this->assertEquals(Bool::NULL_CODE, $this->object->validate($this->meta, null));
    }

	/**
	 * @dataProvider providerTypeCode
	 */
	public function testValidateTypeCode($val)
	{
		$this->assertEquals(Bool::TYPE_CODE, $this->object->validate($this->meta, $val));
	}

	/**
	 * @dataProvider providerPass
	 */
	public function testValidatePass($val)
	{
		$this->assertTrue($this->object->validate($this->meta, $val));
	}

	public function testValidatePassNull()
	{
		$this->meta->null = true;

		$this->assertTrue($this->object->validate($this->meta, null));
	}

    /**
     * @covers Gacela\Field\Bool::transform
	 * @dataProvider provider
     */
    public function testTransformIn($val, $in, $out)
    {
		$this->assertSame($in, $this->object->transform($this->meta, $val, true));
    }

	/**
	 * @covers Gacela\Field\Bool::transform
	 * @dataProvider provider
	 */
	public function testTransformOut($val, $in, $out)
	{
		$this->assertSame($out, $this->object->transform($this->meta, $val, false));
	}

}