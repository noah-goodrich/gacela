<?php
namespace Gacela\Field;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-10-01 at 15:13:51.
 */
class BinaryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \stdClass
     */
    protected $meta;

	/**
	 * @var Binary
	 */
	protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$this->object = new Binary;

        $this->meta = (object) array(
			'type' => 'binary',
			'length' => 10,
			'null' => false
		);
    }

    /**
     * @covers Gacela\Field\Binary::validate
     */
    public function testValidateLengthCode()
    {
		$this->assertEquals(Binary::LENGTH_CODE, $this->object->validate($this->meta, 'I am a long bit of data'));
    }

	public function testValidateNullCode()
	{
		$this->assertEquals(Binary::NULL_CODE, $this->object->validate($this->meta, null));
	}

	public function testValidatePassNull()
	{
		$this->meta->null = true;

		$this->assertTrue($this->object->validate($this->meta, null));
	}

    /**
     * @covers Gacela\Field\Binary::transform
     * @todo   Implement testTransform().
     */
    public function testTransform()
    {
		$value = 'value';

        $this->assertSame($value, $this->object->transform($this->meta, $value));
    }
}
