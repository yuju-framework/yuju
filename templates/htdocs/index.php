<?php
/**
 * Index File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
session_start();
require '../conf/site.php';
date_default_timezone_set(TIMEZONE);

function handlererrors($num_err, $cadena_err, $archivo_err, $linea_err, $vars)
{
    $type_error = array (
        E_ERROR              => _('Error'),
        E_WARNING            => _('Warning'),
        E_PARSE              => _('Parse error'),
        E_NOTICE             => _('Notice'),
        E_CORE_ERROR         => _('Core Error'),
        E_CORE_WARNING       => _('Core warning'),
        E_COMPILE_ERROR      => _('Compile error'),
        E_COMPILE_WARNING    => _('Compile warning'),
        E_USER_ERROR         => _('User error'),
        E_USER_WARNING       => _('Warning error'),
        E_USER_NOTICE        => _('Notice error'),
        E_STRICT             => _('Strict error'),
        E_RECOVERABLE_ERROR  => _('Recoverable error')
    );
    $err=print_r($vars, true);

    //mail(MAILADM,'error: '.NOMBREPROYECTO,"codigo error: ".$tipo_error[$num_err]."\nerror: ".$cadena_err."\narchivo: ".$archivo_err."\nlinea: ".$linea_err."\nvar: ".$err);
}
if (defined('DEBUG') && !DEBUG) {
    set_error_handler("handlererrors");
}
/**
 * Autoload classes
 *
 * @param string $class_name class name
 *
 * @return void
 */
function classAutoLoad($class_name)
{
    if (file_exists(ROOT.'class/'.$class_name . '.php')) {
        include_once ROOT.'class/'.$class_name . '.php';
    } elseif (file_exists(API.'class/'.$class_name . '.php')) {
        include_once API.'class/'.$class_name . '.php';
    }
}

putenv("LC_ALL=".LANGUAGE);
setlocale(LC_ALL, LANGUAGE);
bindtextdomain("messages", ROOT."locales");
bind_textdomain_codeset("messages", "UTF-8");
textdomain("messages");

// Load WebPage
if (defined('API')) {
    include API.'class/Yuju_View.php';
} else {
    include ROOT.'class/Yuju_View.php';
}
$view=new Yuju_View();
spl_autoload_register('classAutoLoad');
if (isset($_SESSION['user'])) {
    $activeuser=unserialize($_SESSION['user']);
} else {
    // Load Object User
    $activeuser=new User();
}
// If slash, location 301 without slash
if (substr($_GET['p'], -1)=='/') {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: '.DOMAIN.substr($_GET['p'], 0, strlen($_GET['p'])-1));
    exit;
}

$view->display($view->getPage($_GET['p']).'.tpl', $_SERVER['REQUEST_URI']);
