<?php
/**
 * Boolean Test File
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
namespace YujuFramework\Test;

use stdClass;
use \Exception;
use \YujuFramework\Boolean;

/**
 * Boolean Class
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class BooleanTest extends \PHPUnit_Framework_TestCase
{
    protected $boolean;
    
    public function setUp()
    {
        $this->boolean = new Boolean();
    }
    
    /**
     * testConstruct
     *
     * @covers \YujuFramework\Boolean::__construct
     * @uses \YujuFramework\Boolean
     */
    public function testConstruct()
    {
        $this->assertEquals($this->boolean->getValue(), '');
    }
    
    /**
     * testSetValue
     *
     * @covers \YujuFramework\Boolean::setValue
     * @covers \YujuFramework\Boolean::isBoolean
     * @uses \YujuFramework\Boolean
     */
    public function testSetValue()
    {
        $this->assertTrue($this->boolean->setValue(null));
        $this->assertTrue($this->boolean->setValue(''));
        $this->assertTrue($this->boolean->setValue(true));
        $this->assertTrue($this->boolean->setValue(false));
        $this->assertTrue($this->boolean->setValue(0));
        $this->assertTrue($this->boolean->setValue(1));
    }
    
    /**
     * testSetValueInvalid
     *
     * @covers \YujuFramework\Boolean::setValue
     * @covers \YujuFramework\Boolean::isBoolean
     * @uses \YujuFramework\Boolean
     */
    public function testSetValueInvalid()
    {
        $this->assertFalse($this->boolean->setValue('hello'));
        $this->assertFalse($this->boolean->setValue(25));
        $this->assertFalse($this->boolean->setValue(258.369));
        $this->assertFalse($this->boolean->setValue(new stdClass));
    }
    
    /**
     * testGetValue
     *
     * @covers \YujuFramework\Boolean::getValue
     * @covers \YujuFramework\Boolean::isBoolean
     * @uses \YujuFramework\Boolean
     */
    public function testGetValue()
    {
        $this->assertTrue($this->boolean->setValue(null));
        $this->assertEquals($this->boolean->getValue(), '');
        $this->assertTrue($this->boolean->setValue(''));
        $this->assertEquals($this->boolean->getValue(), '');
        $this->assertTrue($this->boolean->setValue(true));
        $this->assertEquals($this->boolean->getValue(), true);
        $this->assertTrue($this->boolean->setValue(false));
        $this->assertEquals($this->boolean->getValue(), false);
        $this->assertTrue($this->boolean->setValue(0));
        $this->assertEquals($this->boolean->getValue(), false);
        $this->assertTrue($this->boolean->setValue(1));
        $this->assertEquals($this->boolean->getValue(), true);
    }
    
    /**
     * testToDB
     *
     * @covers \YujuFramework\Boolean::toDB
     * @uses \YujuFramework\Boolean
     */
    public function testToDB()
    {
        $this->assertTrue($this->boolean->setValue(null));
        $this->assertEquals($this->boolean->toDB(), 'NULL');
        $this->assertTrue($this->boolean->setValue(''));
        $this->assertEquals($this->boolean->toDB(), 'NULL');
        $this->assertTrue($this->boolean->setValue(true));
        $this->assertEquals($this->boolean->toDB(), 1);
        $this->assertTrue($this->boolean->setValue(false));
        $this->assertEquals($this->boolean->toDB(), 0);
        $this->assertTrue($this->boolean->setValue(0));
        $this->assertEquals($this->boolean->toDB(), 0);
        $this->assertTrue($this->boolean->setValue(1));
        $this->assertEquals($this->boolean->toDB(), 1);
    }
    
    /**
     * testGetNameValue
     *
     * @covers \YujuFramework\Boolean::getNameValue
     * @uses \YujuFramework\Boolean
     */
    public function testGetNameValue()
    {
        $this->assertTrue($this->boolean->setValue(null));
        $this->assertEquals($this->boolean->getNameValue(), '');
        $this->assertTrue($this->boolean->setValue(''));
        $this->assertEquals($this->boolean->getNameValue(), '');
        $this->assertTrue($this->boolean->setValue(true));
        $this->assertEquals($this->boolean->getNameValue(), 'Yes');
        $this->assertTrue($this->boolean->setValue(false));
        $this->assertEquals($this->boolean->getNameValue(), 'No');
        $this->assertTrue($this->boolean->setValue(0));
        $this->assertEquals($this->boolean->getNameValue(), 'No');
        $this->assertTrue($this->boolean->setValue(1));
        $this->assertEquals($this->boolean->getNameValue(), 'Yes');
    }
    
    /**
     * testGetBoolean
     *
     * @covers \YujuFramework\Boolean::getBoolean
     * @covers \YujuFramework\Boolean::isBoolean
     * @uses \YujuFramework\Boolean
     */
    public function testGetBoolean()
    {
        $this->assertTrue($this->boolean->setValue(null));
        $this->assertEquals($this->boolean->getBoolean(), null);
        $this->assertTrue($this->boolean->setValue(''));
        $this->assertEquals($this->boolean->getBoolean(), null);
        $this->assertTrue($this->boolean->setValue(true));
        $this->assertEquals($this->boolean->getBoolean(), true);
        $this->assertTrue($this->boolean->setValue(false));
        $this->assertEquals($this->boolean->getBoolean(), false);
        $this->assertTrue($this->boolean->setValue(0));
        $this->assertEquals($this->boolean->getBoolean(), false);
        $this->assertTrue($this->boolean->setValue(1));
        $this->assertEquals($this->boolean->getBoolean(), true);
    }
}
