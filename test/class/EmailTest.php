<?php
/**
 * EmailTest File
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Class EmailTest
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class EmailTest extends PHPUnit_Framework_TestCase
{
    /**
     * Function made to test valid email strings
     *
     * @return void
     */
    public function testValidEmail()
    {
        $this->assertTrue(Email::validEmail('test@test.com'));
        $this->assertTrue(Email::validEmail('test@d1.test.com'));
        $this->assertTrue(Email::validEmail('test.d1@d1.test.com'));
    }
    /**
     * Function made to test invalid email strings
     *
     * @return void
     */
    public function testInValidEmail()
    {
        $this->assertFalse(Email::validEmail('test'));
        $this->assertFalse(Email::validEmail('test@test'));
        $this->assertFalse(Email::validEmail('test@test/.com'));
        $this->assertFalse(Email::validEmail('test@test*.com'));
        $this->assertFalse(Email::validEmail('test*@test.com'));
        $this->assertFalse(Email::validEmail('test/@test.com'));
    }
}
