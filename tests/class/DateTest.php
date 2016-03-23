<?php
/**
 * Date Test File
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
use \YujuFramework\Date;

/**
 * DateTest Class
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    protected $date;
    
    public function setUp()
    {
        $this->date = new Date();
    }
    
    /**
     * testConstruct
     *
     * @covers \YujuFramework\Date::__construct
     * @uses \YujuFramework\Date
     */
    public function testConstruct()
    {
        $this->assertEquals($this->date->toDB(), 'NULL');
    }
    
    /**
     * testSetDate
     *
     * @covers \YujuFramework\Date::setDate
     * @uses \YujuFramework\Date
     */
    public function testSetDate()
    {
        $this->assertTrue($this->date->setDate(1, 2, 1856));
        $this->assertTrue($this->date->setDate(1, 2, 2002));
        $this->assertTrue($this->date->setDate(31, 12, 2002));
        $this->assertTrue($this->date->setDate(1, 1, 2002));
        $this->assertTrue($this->date->setDate(1, 1, 3000));
        $this->assertTrue($this->date->setDate(0, 0, 0));
    }
    
    /**
     * testSetDateInvalid
     *
     * @covers \YujuFramework\Date::setDate
     * @uses \YujuFramework\Date
     */
    public function testSetDateInvalid()
    {
        $this->assertFalse($this->date->setDate(null, null, null));
        $this->assertFalse($this->date->setDate('notnumber', 'notnumber', 'notnumber'));
        $this->assertFalse($this->date->setDate(31, 02, 2002));
    }
}
