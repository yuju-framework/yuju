<?php
/**
 * Smarty {html_submit} function plugin
 *
 * @param array $params parameters
 * name              - Nombre del campo
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string
 */

function smarty_function_html_submit($params, $template)
{
  $value = '';
  $id    = '';
  $name  = '';
  foreach($params as $_key => $_val) {
    switch ($_key) {
    case 'name':
        $name=$_val;
        break;
    case 'id':
        $id=$_val;
        break;
    case 'value':
        $value=$_val;
        break;
    }
  }

  if (!isset($name))
  return '';

  $_html_result = '<input type="submit" name="'.$name.'" id="'.$id.'" value="'.$value.'" />';
  return $_html_result;
}
?>
