<?php
/**
 * Login module File
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
 * @category Module
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: main.php 87 2013-05-05 18:54:22Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
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
                $response['response'] = $template->fetch(ROOT.'modules/'.$rpc_params['module'] . '/view/main-admin.tpl');
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