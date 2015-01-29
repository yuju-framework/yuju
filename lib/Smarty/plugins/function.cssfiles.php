<?php
/**
 * Smarty {cssfile} function plugin
 *
 * @param array $params parameters
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string
 */

function smarty_function_cssfiles($params, $template)
{
    $css='';
    $cssfiles=$template->getTemplateVars('cssfiles');
    foreach ($cssfiles as $file) {
        $css.='<link rel="stylesheet" type="text/css" href="'.$file.'" />';
    }
    return $css;
}
?>
