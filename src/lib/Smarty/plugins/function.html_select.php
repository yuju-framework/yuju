<?php
/**
 * Smarty {html_multiselect_autocomplete} function plugin
 *
 * @param array $params parameters
 * json_url         - url to fetch json object
 * cache       		- use cache
 * height           - maximum number of element shown before scroll will apear
 * newel            - show typed text like a element
 * firstselected	- automaticly select first element from dropdown
 * filter_case      - case sensitive filter
 * filter_selected  - filter selected items from list
 * complete_text    - text for complete page
 * maxshownitems	- maximum numbers that will be shown at dropdown list (less better performance)
 * onselect			- fire event on item select
 * onremove			- fire event on item remove
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string
 */

function smarty_function_html_select($params, $template)
{
  $name='';
  $value='';

  foreach($params as $_key => $_val) {
    switch ($_key) {
      case 'name':
        $name=$_val;
        break;
      case 'value':
        $value =$_val;
        break;
      case 'object':
        $object =new $_val;
        break;
    }
  }

  if (!isset($object))
  return '';

  $_html_result = '<select name="'.$name.'" id="'.$name.'">';
  $_html_result .= '<option value="">Selecciona</option>';
  $todos=$object->getTodos();
  foreach($todos as $t){
    $_html_result .='<option value="'.$t->getId().'"';
    if($t->getId()==$value)
    $_html_result .=' selected="selected"';
    $_html_result .='>'.$t->getValue().'</option>';
  }
  $_html_result .='</select>';
  return $_html_result;
}
?>
