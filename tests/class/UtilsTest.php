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

use YujuFramework\User;
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
     * testValidPager
     *
     * @covers \YujuFramework\Utils::pager
     * @uses \YujuFramework\Utils
     */
    public function testValidPager()
    {
        $this->assertEquals(Utils::pager(2, 1, 0, 'url'), '');
        $this->assertEquals(Utils::pager(2, 1, 1, 'url'), '1');
        $this->assertEquals(Utils::pager(2, 1, 3, 'url'), ' 1 <a href="url2">2</a> <a href="url2">Last</a>');
        $this->assertEquals(
            Utils::pager(2, 3, 5, 'url'),
            '<a href="url1">First</a> <a href="url1">1</a> <a href="url2">2</a> 3'
        );
        $this->assertEquals(
            Utils::pager(2, 3, 10, 'url'),
            '<a href="url1">First</a> <a href="url1">1</a> <a href="url2">2</a> 3'
            .' <a href="url4">4</a> <a href="url5">5</a> <a href="url5">Last</a>'
        );
    }
    
    /**
     * testValidEmail
     *
     * @covers \YujuFramework\Utils::validEmail
     * @uses \YujuFramework\Utils
     */
    public function testValidEmail()
    {
        $this->assertTrue(Utils::validEmail('test@test.com'));
        $this->assertTrue(Utils::validEmail('test@d1.test.com'));
        $this->assertTrue(Utils::validEmail('test.d1@d1.test.com'));
    }
    
    /**
     * testInValidEmail
     *
     * @covers \YujuFramework\Utils::validEmail
     * @uses \YujuFramework\Utils
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
    
    /**
     * testValidURI
     *
     * @covers \YujuFramework\Utils::validURI
     * @uses \YujuFramework\Utils
     */
    public function testValidURI()
    {
        $this->assertTrue(Utils::validURI('http://www.test.com'));
        $this->assertTrue(Utils::validURI('http://test.com'));
        $this->assertTrue(Utils::validURI('http://www.test.museum'));
        $this->assertTrue(Utils::validURI('http://www.test.test'));
    }
    
    /**
     * testInValidURI
     *
     * @covers \YujuFramework\Utils::validURI
     * @uses \YujuFramework\Utils
     */
    public function testInValidURI()
    {
        $this->assertFalse(Utils::validURI('www.test.com'));
        $this->assertFalse(Utils::validURI('http://te`st.com'));
        $this->assertFalse(Utils::validURI(''));
    }
    
    /**
     * testInValidURI
     *
     * @covers \YujuFramework\Utils::getAleatoryText
     * @uses \YujuFramework\Utils
     */
    public function testGetAleatoryText()
    {
        $this->assertEquals(strlen(Utils::getAleatoryText(3)), 3);
        $number1 = Utils::getAleatoryText(3);
        $number2 = Utils::getAleatoryText(3);
        $this->assertNotEquals($number1, $number2);
    }
}
