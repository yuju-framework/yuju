<?php
/**
 * Smarty {html_text} function plugin
 *
 * @param array $params parameters
 * name              - Nombre del campo
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string
 */

function smarty_function_tourl($params, $template)
{
  return YujuView::tourl($params['value']);
}
?>