<?php
/**
 * EmailTest File
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
 * Class EmailTest
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
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