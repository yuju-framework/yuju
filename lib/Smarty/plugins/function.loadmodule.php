<?php

function smarty_function_loadmodule($params, $template)
{
    global $activeuser;
    global $view;
    if (is_file(ROOT . 'modules/' . $params['modname'] . '/controller/main.php')) {
        include ROOT . 'modules/' . $params['modname'] . '/controller/main.php';
    } elseif (is_file(API . 'modules/' . $params['modname'] . '/controller/main.php')) {
        include API . 'modules/' . $params['modname'] . '/controller/main.php';
    }
}

?>
