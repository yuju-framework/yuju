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
namespace YujuFramework\Test;

use YujuFramework\Utils;

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
class UtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Function made to test valid email strings
     *
     * @return void
     */
    public function testValidEmail()
    {
        $this->assertTrue(Utils::validEmail('test@test.com'));
        $this->assertTrue(Utils::validEmail('test@d1.test.com'));
        $this->assertTrue(Utils::validEmail('test.d1@d1.test.com'));
    }
    /**
     * Function made to test invalid email strings
     *
     * @return void
     */
    public function testInValidEmail()
    {
        $this->assertFalse(Utils::validEmail('test'));
        $this->assertFalse(Utils::validEmail('test@test'));
        $this->assertFalse(Utils::validEmail('test@test/.com'));
        $this->assertFalse(Utils::validEmail('test@test*.com'));
        $this->assertFalse(Utils::validEmail('test*@test.com'));
        $this->assertFalse(Utils::validEmail('test/@test.com'));
    }
}
