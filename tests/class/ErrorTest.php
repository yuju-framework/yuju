<?php
/**
 * Error Test File
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
use \YujuFramework\Error;

/**
 * ErrorTest Class
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class ErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testSetErrors
     *
     * @covers \YujuFramework\Error::setError
     * @covers \YujuFramework\Error::getErrors
     * @covers \YujuFramework\Error::clean
     * @uses \YujuFramework\Error
     */
    public function testSetErrors()
    {
        Error::setError('test1', 'Set error test 1');
        $this->assertEquals(Error::getErrors(), array(array('test1', 'Set error test 1')));
        Error::clean();
        Error::setError('test1', 'Set error test 1');
        Error::setError('test2', 'Set error test 2');
        $errors = array(
            array('test1', 'Set error test 1'),
            array('test2', 'Set error test 2')
        );
        $this->assertEquals(Error::getErrors(), $errors);
        Error::clean();
    }
    
    /**
     * testExist
     *
     * @covers \YujuFramework\Error::exist
     * @uses \YujuFramework\Error
     */
    public function testExist()
    {
        $this->assertFalse(Error::exist());
        Error::setError('test1', 'Set error test 1');
        $this->assertTrue(Error::exist());
        Error::clean();
    }
    
    /**
     * testHaveError
     *
     * @covers \YujuFramework\Error::haveError
     * @uses \YujuFramework\Error
     */
    public function testHaveError()
    {
        $this->assertFalse(Error::haveError('test1'));
        Error::setError('test1', 'Set error test 1');
        $this->assertTrue(Error::haveError('test1'));
        $this->assertFalse(Error::haveError('test2'));
        Error::clean();
    }
    
    /**
     * testToString
     *
     * @covers \YujuFramework\Error::toString
     * @uses \YujuFramework\Error
     */
    public function testToString()
    {
        $this->assertEquals(Error::toString(), '');
        Error::setError('test1', 'Set error test 1');
        $this->assertEquals(Error::toString(), 'Set error test 1');
        Error::setError('test2', 'Set error test 2');
        $this->assertEquals(Error::toString(), "Set error test 1\nSet error test 2");
        Error::clean();
    }
    
    /**
     * testToHTML
     *
     * @covers \YujuFramework\Error::toHTML
     * @uses \YujuFramework\Error
     */
    public function testToHTML()
    {
        $this->assertEquals(Error::toHTML(), '');
        Error::setError('test1', 'Set error test 1');
        $this->assertEquals(Error::toHTML(), 'Set error test 1');
        Error::setError('test2', 'Set error test 2');
        $this->assertEquals(Error::toHTML(), "Set error test 1<br>Set error test 2");
        Error::clean();
    }
}
