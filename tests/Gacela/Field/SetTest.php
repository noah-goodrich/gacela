<?php
namespace Gacela\Field;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-09-30 at 06:31:11.
 */
class SetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Set
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = (object) array(
			'type' => 'set',
			'values' => array(1, 'one', 'two', 2)
		);
    }

	public function providerValueCode()
	{
		return array(
			array(3),
			array('three'),
			array(array(1, 3)),
			array(array('two', 4))
		);
	}


    /**
     * @covers Gacela\Field\Set::validate
	 * @dataProvider providerValueCode
     */
    public function testValidateValueCode($value)
    {
        $this->assertEquals(Set::VALUE_CODE, Set::validate($this->object, $value));
    }

    /**
     * @covers Gacela\Field\Set::transform
     */
    public function testTransform()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
