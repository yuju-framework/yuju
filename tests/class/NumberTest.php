<?php
/**
 * Number Test File
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
namespace YujuFramework\Test;

use YujuFramework\Number;

/**
 * NumberTest Class
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class NumberTest extends \PHPUnit_Framework_TestCase
{

    protected $number;

    /**
     * Set Up
     *
     * @return void
     */
    protected function setUp()
    {
        $this->number = new Number();
    }

    /**
     * Test Construct
     *
     * @return void
     */
    public function testIntegerSetValue()
    {
        $this->setUp();
        $this->assertTrue($this->number->setValue(1));
        $this->assertEquals($this->number->getValue(), 1);
        $this->assertTrue($this->number->setValue(-1));
        $this->assertEquals($this->number->getValue(), -1);
    }

    /**
     * Test Construct
     *
     * @return void
     */
    public function testDecimalSetValue()
    {
        $this->number = new Number(Number::DECIMAL, false, 1, 1);
        $this->assertTrue($this->number->setValue(1.0));
        $this->assertEquals($this->number->getValue(), 1.0);
        $this->assertTrue($this->number->setValue(-1.0));
        $this->assertEquals($this->number->getValue(), -1.0);
    }

    public function testFloatSetValue()
    {
        $this->number = new Number(Number::FLOAT);
        $this->assertTrue($this->number->setValue(1.0));
        $this->assertEquals($this->number->getValue(), 1.0);
        $this->assertTrue($this->number->setValue(-1.0));
        $this->assertEquals($this->number->getValue(), -1.0);
    }

    /**
     * Test integer set values invalid
     *
     * @return void
     */
    public function testIntegerSetValueInvalid()
    {
        $this->number = new Number(Number::INTEGER);
        $this->assertFalse($this->number->setValue(2.36));
        $this->assertFalse($this->number->setValue(-2.36));
        $this->assertFalse($this->number->setValue('hello'));
        $this->assertFalse($this->number->setValue(pi()));
    }

    /**
     * Test integer set values invalid
     *
     * @return void
     */
    /* public function testFloatSetValueInvalid()
      {
      $this->number = new Number(Number::FLOAT);
      $this->assertTrue($this->number->setValue(2.36));
      $this->assertTrue($this->number->setValue(-2.36));
      $this->assertFalse($this->number->setValue('hello'));
      $this->assertTrue($this->number->setValue(pi()));
      } */

    /**
     * Test integer unsigned values
     *
     * @return void
     */
    public function testIntegerSetValueUnsigned()
    {
        $this->number = new Number(Number::INTEGER, true);
        $this->assertTrue($this->number->setValue(236));
        $this->assertTrue($this->number->setValue("236"));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    /**
     * Test integer unsigned values
     *
     * @return void
     */

    public function testDecimalSetValueUnsigned()
    {
        $this->number = new Number(Number::DECIMAL, true, 3, 3);
        $this->assertTrue($this->number->setValue(236));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertFalse($this->number->setValue(236.2565));
        $this->assertFalse($this->number->setValue(-236.2585));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    public function testFloatSetValueUnsigned()
    {
        $this->number = new Number(Number::FLOAT, true);
        $this->assertTrue($this->number->setValue(236));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    /**
     * Test integer unsigned values with integer and decimal
     *
     * @return void
     */
    public function testIntegerSetValueUnsignedIntegerDecimal()
    {
        $this->number = new Number(Number::INTEGER, true, 23, 26);
        $this->assertTrue($this->number->setValue(236));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    public function testDecimalSetValueUnsignedIntegerDecimal()
    {
        $this->number = new Number(Number::DECIMAL, true, 23, 26);
        $this->assertTrue($this->number->setValue(236));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }
    public function testFloatSetValueUnsignedIntegerDecimal()
    {
        $this->number = new Number(Number::FLOAT, true, 23, 26);
        $this->assertTrue($this->number->setValue(236));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    /**
     * Test integer signed values with integer and decimal
     *
     * @return void
     */
    public function testIntegerSetValueSignedIntegerDecimal()
    {
        $this->number = new Number(Number::INTEGER, false, 23, 26);
        $this->assertTrue($this->number->setValue(236));
        $this->assertTrue($this->number->setValue(-236));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    public function testDecimalSetValueSignedIntegerDecimal()
    {
        $this->number = new Number(Number::DECIMAL, false, 23, 26);
        $this->assertTrue($this->number->setValue(236));
        $this->assertTrue($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertTrue($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }
    public function testFloatSetValueSignedIntegerDecimal()
    {
        $this->number = new Number(Number::FLOAT, false, 23, 26);
        $this->assertTrue($this->number->setValue(236));
        $this->assertTrue($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertTrue($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    /**
     * Test integer signed values with max and min
     *
     * @return void
     */
    public function testIntegerSetValueSignedMaxMin()
    {
        $this->number = new Number(Number::INTEGER, false, 23, 26, 100, -100);
        $this->assertTrue($this->number->setValue(23));
        $this->assertTrue($this->number->setValue(-23));
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    public function testDecimalSetValueSignedMaxMin()
    {
        $this->number = new Number(Number::DECIMAL, false, 23, 26, 100, -100);
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(23.0));
        $this->assertTrue($this->number->setValue(-23.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }
    public function testFloatSetValueSignedMaxMin()
    {
        $this->number = new Number(Number::FLOAT, false, 23, 26, 100, -100);
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(23.0));
        $this->assertTrue($this->number->setValue(-23.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    /**
     * Test integer unsigned values with max and min
     *
     * @return void
     */
    public function testIntegerSetValueUnsignedMaxMin()
    {
        $this->number = new Number(Number::INTEGER, true, 23, 26, 100, -100);
        $this->assertTrue($this->number->setValue(23));
        $this->assertFalse($this->number->setValue(-23));
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));

        $this->number = new Number(Number::DECIMAL, true, 23, 26, 100, 50);
        $this->assertTrue($this->number->setValue(80.0));
        $this->assertFalse($this->number->setValue(20.0));
        $this->assertFalse($this->number->setValue(10.0));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));

        $this->number = new Number(Number::FLOAT, true, 23, 26, 100, 50);
        $this->assertTrue($this->number->setValue(80.0));
        $this->assertFalse($this->number->setValue(200.0));
        $this->assertFalse($this->number->setValue(10.0));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }

    public function testFloatSetValueUnsignedMaxMin()
    {
        $this->number = new Number(Number::FLOAT, true, 23, 26, 100, -100);
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(23.0));
        $this->assertFalse($this->number->setValue(-23.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertTrue($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));

        $this->number = new Number(Number::DECIMAL, true, 23, 26, 100, 50);
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(80.0));
        $this->assertFalse($this->number->setValue(200.0));
        $this->assertFalse($this->number->setValue(10.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));

        $this->number = new Number(Number::FLOAT, true, 23, 26, 100, 50);
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(80.0));
        $this->assertFalse($this->number->setValue(200.0));
        $this->assertFalse($this->number->setValue(10.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->assertFalse($this->number->setValue(pi()));
        $this->assertFalse($this->number->setValue('hello'));
    }
}
