<?php
/**
 * Text File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Class Text
 *
 * @category Core
 * @package  YujuFramework
 * @author   Carlos Melgarejo <cmelgarejo@peopletic.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
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
