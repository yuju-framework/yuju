<?php
/**
 * Yuju common command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Show help
 *
 * @return void
 */
function showHelp()
{
    global $argv;
    echo "Usage: $argv[0] create\n";
    echo "       $argv[0] delete <directory>\n";
    echo "       $argv[0] compile <directory> <modname|'compile-all-web-pages'>\n";
    echo "       $argv[0] orm <directory> <object> <type> <table> [object name]\n";
}
