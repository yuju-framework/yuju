<?php

/**
 * Number Test File
 *
 * PHP version 5
 *
 * Copyright individual contributors as indicated by the @authors tag.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  GIT: 
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * NumberTest Class
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class NumberTest extends PHPUnit_Framework_TestCase
{

    protected $_number;

    /**
     * Set Up
     * 
     * @return void
     */
    protected function setUp()
    {
        $this->_number = new Number();
    }

    /**
     * Test Construct
     * 
     * @return void
     */
    public function testIntegerSetValue()
    {
        $this->setUp();
        $this->assertTrue($this->_number->setValue(1));
        $this->assertEquals($this->_number->getValue(), 1);
        $this->assertTrue($this->_number->setValue(-1));
        $this->assertEquals($this->_number->getValue(), -1);
    }

    /**
     * Test Construct
     * 
     * @return void
     */
    public function testDecimalSetValue()
    {
        $this->_number = new Number(Number::DECIMAL, false, 1, 1);
        $this->assertTrue($this->_number->setValue(1.0));
        $this->assertEquals($this->_number->getValue(), 1.0);
        $this->assertTrue($this->_number->setValue(-1.0));
        $this->assertEquals($this->_number->getValue(), -1.0);
    }

    public function testFloatSetValue()
    {
        $this->_number = new Number(Number::FLOAT);
        $this->assertTrue($this->_number->setValue(1.0));
        $this->assertEquals($this->_number->getValue(), 1.0);
        $this->assertTrue($this->_number->setValue(-1.0));
        $this->assertEquals($this->_number->getValue(), -1.0);
    }

    /**
     * Test integer set values invalid
     * 
     * @return void
     */
    public function testIntegerSetValueInvalid()
    {
        $this->_number = new Number(Number::INTEGER);
        $this->assertFalse($this->_number->setValue(2.36));
        $this->assertFalse($this->_number->setValue(-2.36));
        $this->assertFalse($this->_number->setValue('hello'));
        $this->assertFalse($this->_number->setValue(pi()));
    }

    /**
     * Test integer set values invalid
     * 
     * @return void
     */
    /* public function testFloatSetValueInvalid()
      {
      $this->_number = new Number(Number::FLOAT);
      $this->assertTrue($this->_number->setValue(2.36));
      $this->assertTrue($this->_number->setValue(-2.36));
      $this->assertFalse($this->_number->setValue('hello'));
      $this->assertTrue($this->_number->setValue(pi()));
      } */

    /**
     * Test integer unsigned values
     *
     * @return void
     */
    public function testIntegerSetValueUnsigned()
    {
        $this->_number = new Number(Number::INTEGER, true);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertTrue($this->_number->setValue("236"));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    /**
     * Test integer unsigned values
     *
     * @return void
     */
    
    public function testDecimalSetValueUnsigned()
    {
        $this->_number = new Number(Number::DECIMAL, true, 3, 3);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertTrue($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertFalse($this->_number->setValue(236.2565));
        $this->assertFalse($this->_number->setValue(-236.2585));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }
    
    public function testFloatSetValueUnsigned()
    {
        $this->_number = new Number(Number::FLOAT, true);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertTrue($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    /**
     * Test integer unsigned values with integer and decimal
     *
     * @return void
     */
    public function testIntegerSetValueUnsignedIntegerDecimal()
    {
        $this->_number = new Number(Number::INTEGER, true, 23, 26);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    public function testDecimalSetValueUnsignedIntegerDecimal()
    {
        $this->_number = new Number(Number::DECIMAL, true, 23, 26);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertTrue($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }
    public function testFloatSetValueUnsignedIntegerDecimal()
    {
        $this->_number = new Number(Number::FLOAT, true, 23, 26);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertFalse($this->_number->setValue(-236));
        $this->assertTrue($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    /**
     * Test integer signed values with integer and decimal
     *
     * @return void
     */
    public function testIntegerSetValueSignedIntegerDecimal()
    {
        $this->_number = new Number(Number::INTEGER, false, 23, 26);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertTrue($this->_number->setValue(-236));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    public function testDecimalSetValueSignedIntegerDecimal()
    {
        $this->_number = new Number(Number::DECIMAL, false, 23, 26);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertTrue($this->_number->setValue(-236));
        $this->assertTrue($this->_number->setValue(236.256));
        $this->assertTrue($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }
    public function testFloatSetValueSignedIntegerDecimal()
    {
        $this->_number = new Number(Number::FLOAT, false, 23, 26);
        $this->assertTrue($this->_number->setValue(236));
        $this->assertTrue($this->_number->setValue(-236));
        $this->assertTrue($this->_number->setValue(236.256));
        $this->assertTrue($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    /**
     * Test integer signed values with max and min
     *
     * @return void
     */
    public function testIntegerSetValueSignedMaxMin()
    {
        $this->_number = new Number(Number::INTEGER, false, 23, 26, 100, -100);
        $this->assertTrue($this->_number->setValue(23));
        $this->assertTrue($this->_number->setValue(-23));
        $this->assertFalse($this->_number->setValue(230));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    public function testDecimalSetValueSignedMaxMin()
    {
        $this->_number = new Number(Number::DECIMAL, false, 23, 26, 100, -100);
        $this->assertFalse($this->_number->setValue(230));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertTrue($this->_number->setValue(23.0));
        $this->assertTrue($this->_number->setValue(-23.0));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }
    public function testFloatSetValueSignedMaxMin()
    {
        $this->_number = new Number(Number::FLOAT, false, 23, 26, 100, -100);
        $this->assertFalse($this->_number->setValue(230));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertTrue($this->_number->setValue(23.0));
        $this->assertTrue($this->_number->setValue(-23.0));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    /**
     * Test integer unsigned values with max and min
     *
     * @return void
     */
    public function testIntegerSetValueUnsignedMaxMin()
    {
        $this->_number = new Number(Number::INTEGER, true, 23, 26, 100, -100);
        $this->assertTrue($this->_number->setValue(23));
        $this->assertFalse($this->_number->setValue(-23));
        $this->assertFalse($this->_number->setValue(230));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));

        $this->_number = new Number(Number::DECIMAL, true, 23, 26, 100, 50);
        $this->assertTrue($this->_number->setValue(80.0));
        $this->assertFalse($this->_number->setValue(20.0));
        $this->assertFalse($this->_number->setValue(10.0));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
        
        $this->_number = new Number(Number::FLOAT, true, 23, 26, 100, 50);
        $this->assertTrue($this->_number->setValue(80.0));
        $this->assertFalse($this->_number->setValue(200.0));
        $this->assertFalse($this->_number->setValue(10.0));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

    public function testFloatSetValueUnsignedMaxMin()
    {
        $this->_number = new Number(Number::FLOAT, true, 23, 26, 100, -100);
        $this->assertFalse($this->_number->setValue(230));
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertTrue($this->_number->setValue(23.0));
        $this->assertFalse($this->_number->setValue(-23.0));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertTrue($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));

        $this->_number = new Number(Number::DECIMAL, true, 23, 26, 100, 50);
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertTrue($this->_number->setValue(80.0));
        $this->assertFalse($this->_number->setValue(200.0));
        $this->assertFalse($this->_number->setValue(10.0));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
        
        $this->_number = new Number(Number::FLOAT, true, 23, 26, 100, 50);
        $this->assertFalse($this->_number->setValue(-230));
        $this->assertTrue($this->_number->setValue(80.0));
        $this->assertFalse($this->_number->setValue(200.0));
        $this->assertFalse($this->_number->setValue(10.0));
        $this->assertFalse($this->_number->setValue(236.256));
        $this->assertFalse($this->_number->setValue(-236.258));
        $this->assertFalse($this->_number->setValue(pi()));
        $this->assertFalse($this->_number->setValue('hello'));
    }

}
