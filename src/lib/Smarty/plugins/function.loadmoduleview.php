<?php

function smarty_function_loadmoduleview($params, $template)
{
    $viewmodule = new YujuView();
    $arguments = '';
    foreach ($params as $param => $value) {
        if ($param != 'modname') {
            $viewmodule->assign($param, $value);
        }
    }
    if (is_file(ROOT . 'modules/' . $params['modname'] . '/view/main.tpl')) {
        return $viewmodule->fetch(ROOT . 'modules/' . $params['modname'] . '/view/main.tpl');
    } elseif (is_file(API . 'modules/' . $params['modname'] . '/view/main.tpl')) {
        return $viewmodule->fetch(API . 'modules/' . $params['modname'] . '/view/main.tpl');
    }
}

?>
