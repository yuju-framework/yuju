<?php
/**
 * Text File
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
 * @category Core
 * @package  YujuFramework
 * @author   Carlos Melgarejo <cmelgarejo@peopletic.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: ACL.php 42 2013-04-17 15:17:53Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Class Text
 *
 * @category Core
 * @package  YujuFramework
 * @author   Carlos Melgarejo <cmelgarejo@peopletic.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class Text
{
    /**
     * Returns a random string
     * 
     * @param int $num The length for the generated string
     * 
     * @return string
     */
    public static function getAleatoryText($num) 
    {
        $text = '';
        for ($c = 0; $c < $num; $c++) {
            $tipo = rand(1, 3);
            switch ($tipo) {
            case 1:
                $text .= chr(rand(48, 57));
                break;
            case 2:
                $text .= chr(rand(65, 90));
                break;
            case 3:
                $text .= chr(rand(97, 122));
                break;
            default:
                $text .= chr(rand(97, 122));
                break;
            }
        }
        return $text;
    }
}
