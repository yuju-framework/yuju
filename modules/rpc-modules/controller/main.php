<?php
/**
 * Login module File
 *
 * @category Module
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  GIT:
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

if (isset($rpc_params['function'])) {
    switch ($rpc_params['function']) {
        case 'all':
            $modules = Yuju_Project::getAllModules(ROOT);
            $response['estate'] = '1';
            $response['response'] = $modules;
            break;
        case 'public':
            $modules = Yuju_Project::getAllPublicModules(ROOT);
            $response['estate'] = '1';
            $response['response'] = $modules;
            break;
        case 'getform':
            $template = new Yuju_View();
            $template->assign('idmod', 0);
            $response['estate'] = '1';
            $response['response'] ='';
            if (file_exists(ROOT.'modules/'.$rpc_params['module'] . '/view/main-admin.tpl')) {
                if (file_exists(ROOT.'modules/'.$rpc_params['module'] . '/controller/main-admin.php')) {
                    include_once ROOT.'modules/'.$rpc_params['module'] . '/controller/main-admin.php';
                }
                $response['response'] =
                    $template->fetch(ROOT.'modules/'.$rpc_params['module'] . '/view/main-admin.tpl');
            } elseif (file_exists(API.'modules/'.$rpc_params['module'] . '/view/main-admin.tpl')) {
                if (file_exists(API.'modules/'.$rpc_params['module'] . '/controller/main-admin.php')) {
                    include_once API.'modules/'.$rpc_params['module'] . '/controller/main-admin.php';
                }
                $response['response'] = $template->fetch(API.'modules/'.$rpc_params['module'] . '/view/main-admin.tpl');
            }

            break;
        default:
            $response['estate'] = '0';
            $response['response'] = _('No function in call');
    }
    echo json_encode($response);
}
