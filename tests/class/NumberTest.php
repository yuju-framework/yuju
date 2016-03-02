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

use \Exception;
use \YujuFramework\Number;

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
     * testConstructTypeException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setType
     * @uses \YujuFramework\Number
     */
    public function testConstructTypeException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number('notype');
    }
    
    /**
     * testConstructType
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setType
     * @uses \YujuFramework\Number
     */
    public function testConstructType()
    {
        $this->number = new Number();
        $this->assertTrue($this->number->setValue(2));
        $this->assertFalse($this->number->setValue(2.25));
    }
    
    /**
     * testConstructUnsignedException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setUnsigned
     * @uses \YujuFramework\Number
     */
    public function testConstructUnsignedException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number(Number::INTEGER, 'unsigned');
    }
    
    /**
     * testConstructUnsigned
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setUnsigned
     * @uses \YujuFramework\Number
     */
    public function testConstructUnsigned()
    {
        $this->number = new Number(Number::INTEGER, true);
        $this->assertTrue($this->number->setValue(2));
        $this->assertFalse($this->number->setValue(-2));
        $this->number = new Number(Number::INTEGER, false);
        $this->assertTrue($this->number->setValue(2));
        $this->assertTrue($this->number->setValue(-2));
    }
    
    /**
     * testConstructPrecisionIntegerException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setPrecision
     * @uses \YujuFramework\Number
     */
    public function testConstructPrecisionIntegerException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number(Number::INTEGER, true, 2);
    }
    
    /**
     * testConstructPrecisionFloatException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setPrecision
     * @uses \YujuFramework\Number
     */
    public function testConstructPrecisionFloatException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number(Number::FLOAT, true, 'notnumber');
    }
    
    /**
     * testConstructPrecisionInteger
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setPrecision
     * @uses \YujuFramework\Number
     */
    public function testConstructPrecisionInteger()
    {
        $this->number = new Number(Number::INTEGER, true, null);
        $this->assertTrue($this->number->setValue(25));
    }
    
    /**
     * testConstructPrecisionFloat
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setPrecision
     * @uses \YujuFramework\Number
     */
    public function testConstructPrecisionFloat()
    {
        $this->number = new Number(Number::FLOAT, true, 2);
        $this->assertTrue($this->number->setValue(25));
        $this->assertTrue($this->number->setValue(25.99));
        $this->assertFalse($this->number->setValue(25.999));
    }
    
    /**
     * testConstructSetMaxException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setMax
     * @uses \YujuFramework\Number
     */
    public function testConstructSetMaxException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number(Number::FLOAT, true, 2, 'notnumber');
    }
    
    /**
     * testConstructSetMax
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setMax
     * @uses \YujuFramework\Number
     */
    public function testConstructSetMax()
    {
        $this->number = new Number(Number::INTEGER, true, null, 5);
        $this->assertTrue($this->number->setValue(1));
        $this->assertTrue($this->number->setValue(5));
        $this->assertFalse($this->number->setValue(6));
        $this->number = new Number(Number::FLOAT, true, 1, 5);
        $this->assertTrue($this->number->setValue(1));
        $this->assertTrue($this->number->setValue(5));
        $this->assertFalse($this->number->setValue(6));
    }
    
    /**
     * testConstructSetMin
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setMin
     * @uses \YujuFramework\Number
     */
    public function testConstructSetMin()
    {
        $this->number = new Number(Number::INTEGER, false, null, 10, 5);
        $this->assertTrue($this->number->setValue(8));
        $this->assertTrue($this->number->setValue(5));
        $this->assertFalse($this->number->setValue(4));
        $this->number = new Number(Number::FLOAT, true, 1, 10, 5);
        $this->assertTrue($this->number->setValue(8));
        $this->assertTrue($this->number->setValue(5));
        $this->assertFalse($this->number->setValue(4));
        $this->number = new Number(Number::INTEGER, true, null, 10, null);
        $this->assertTrue($this->number->setValue(8));
        $this->assertTrue($this->number->setValue(0));
        $this->assertFalse($this->number->setValue(-1));
    }
    
    /**
     * testConstructSetMinException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setMin
     * @uses \YujuFramework\Number
     */
    public function testConstructSetMinException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number(Number::INTEGER, false, null, 10, 'notnumber');
    }
    
    /**
     * testConstructSetMinUnsignedException
     *
     * @covers \YujuFramework\Number::__construct
     * @covers \YujuFramework\Number::setMin
     * @uses \YujuFramework\Number
     */
    public function testConstructSetMinUnsignedException()
    {
        $this->expectException(\Exception::class);
        $this->number = new Number(Number::INTEGER, true, null, 10, -5);
    }
    
    /**
     * testCountPrecision
     *
     * @covers  \YujuFramework\Number::countPrecision
     * @uses \YujuFramework\Number
     */
    public function testCountPrecision()
    {
        $this->number = new Number(Number::FLOAT, true, 3);
        $this->assertTrue($this->number->setValue(25));
        $this->assertTrue($this->number->setValue(25));
        $this->assertFalse($this->number->setValue(2.12346789));
    }
    
    /**
     * testIntegerSetValue
     *
     * @covers \YujuFramework\Number::setValue
     * @covers \YujuFramework\Number::getValue
     * @covers \YujuFramework\Number::ToDB
     * @uses \YujuFramework\Number
     */
    public function testIntegerSetValue()
    {
        $this->number = new Number();
        $this->assertTrue($this->number->setValue(1));
        $this->assertEquals($this->number->getValue(), 1);
        $this->assertEquals($this->number->ToDB(), 1);
        $this->assertTrue($this->number->setValue(''));
        $this->assertEquals($this->number->getValue(), null);
        $this->assertEquals($this->number->ToDB(), 'NULL');
        $this->assertTrue($this->number->setValue(null));
        $this->assertEquals($this->number->getValue(), null);
        $this->assertEquals($this->number->ToDB(), 'NULL');
        $this->assertTrue($this->number->setValue(-1));
        $this->assertEquals($this->number->getValue(), -1);
    }
    
    /**
     * testIntegerSetValueInvalid
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
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
     * testIntegerSetValueUnsigned
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
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
     * testIntegerSetValueSignedMaxMin
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
     */
    public function testIntegerSetValueSignedMaxMin()
    {
        $this->number = new Number(Number::INTEGER, false, null, 100, -100);
        $this->assertTrue($this->number->setValue(23));
        $this->assertTrue($this->number->setValue(-23));
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
        $this->number = new Number(Number::INTEGER);
        $this->assertTrue($this->number->setValue(PHP_INT_MAX));
        $this->assertTrue($this->number->setValue(-PHP_INT_MAX));
        $this->assertFalse($this->number->setValue(PHP_INT_MAX+1));
        $this->assertFalse($this->number->setValue(-PHP_INT_MAX-1));
    }
    
    /**
     * testIntegerSetValueUnsignedMaxMin
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
     */
    public function testIntegerSetValueUnsignedMaxMin()
    {
        $this->number = new Number(Number::INTEGER, true, null, 100, 0);
        $this->assertTrue($this->number->setValue(23));
        $this->assertFalse($this->number->setValue(-23));
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
    }
    
    /**
     * testFloatSetValue
     *
     * @covers \YujuFramework\Number::setValue
     * @covers \YujuFramework\Number::getValue
     * @covers \YujuFramework\Number::ToDB
     * @uses \YujuFramework\Number
     */
    public function testFloatSetValue()
    {
        $this->number = new Number(Number::FLOAT);
        $this->assertTrue($this->number->setValue(1.0));
        $this->assertEquals($this->number->getValue(), 1.0);
        $this->assertTrue($this->number->setValue(-1.0));
        $this->assertEquals($this->number->getValue(), -1.0);
        $this->assertTrue($this->number->setValue(''));
        $this->assertEquals($this->number->getValue(), null);
        $this->assertEquals($this->number->ToDB(), 'NULL');
        $this->assertTrue($this->number->setValue(null));
        $this->assertEquals($this->number->getValue(), null);
        $this->assertEquals($this->number->ToDB(), 'NULL');
    }
    
    /**
     * testFloatSetValueInvalid
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
     */
    public function testFloatSetValueInvalid()
    {
        $this->number = new Number(Number::FLOAT);
        $this->assertFalse($this->number->setValue('hello'));
        $this->assertFalse($this->number->setValue(pi()));
    }
    
    /**
     * testFloatSetValueUnsigned
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
     */
    public function testFloatSetValueUnsigned()
    {
        $this->number = new Number(Number::FLOAT, true, 3);
        $this->assertTrue($this->number->setValue(236));
        $this->assertFalse($this->number->setValue(-236));
        $this->assertTrue($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
    }
    
    /**
     * testFloatSetValueSignedMaxMin
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
     */
    public function testFloatSetValueSignedMaxMin()
    {
        $this->number = new Number(Number::FLOAT, false, 3, 100, -100);
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(23.0));
        $this->assertTrue($this->number->setValue(-23.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
    }
    
    /**
     * testFloatSetValueUnsignedMaxMin
     *
     * @covers \YujuFramework\Number::setValue
     * @uses \YujuFramework\Number
     */
    public function testFloatSetValueUnsignedMaxMin()
    {
        $this->number = new Number(Number::FLOAT, true, 3, 100, 0);
        $this->assertFalse($this->number->setValue(230));
        $this->assertFalse($this->number->setValue(-230));
        $this->assertTrue($this->number->setValue(23.0));
        $this->assertFalse($this->number->setValue(-23.0));
        $this->assertFalse($this->number->setValue(236.256));
        $this->assertFalse($this->number->setValue(-236.258));
    }
}
