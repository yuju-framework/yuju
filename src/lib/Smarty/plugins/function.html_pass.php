<?php
/**
 * Smarty {html_pass} function plugin
 *
 * @param array $params parameters
 * 		name	- Field name
 * 		size	- Input size
 * 		value	- Input value
 * 		max		- Maximum characteres
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string
 */

function smarty_function_html_pass($params, $template)
{
  $size='';
  $max='';
  $value='';
  foreach($params as $_key => $_val) {
    switch ($_key) {
      case 'name':
        $name=$_val;
        break;
      case 'size':
        $size=$_val;
        break;
      case 'max':
        $max=$_val;
        break;
      case 'value':
        $value=$_val;
        break;
    }
  }

  if (!isset($name))
  return '';

  $_html_result = '<input type="password" name="'.$name.'" value="'.$value.'" size="'.$size.'" max="'.$max.'" />';
  return $_html_result;
}
?>
