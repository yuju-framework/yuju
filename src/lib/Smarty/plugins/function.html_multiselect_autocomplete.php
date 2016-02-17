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
 * maxitimes		- maximum items that can be added
 * delay			- delay between ajax request (bigger delay, lower server time request)
 * @param object $smarty Smarty object
 * @param object $template template object
 * @return string
 */

function smarty_function_html_multiselect_autocomplete($params, $template)
{
  $value=array();
  $max='';
  $size='';
  foreach($params as $_key => $_val) {
    switch ($_key) {
      case 'name':
        $name=$_val;
        break;
      case 'data':
        $url =$_val;
        break;
      case 'value':
        $value =$_val;
        break;
      case 'max':
        $max=$_val;
        break;
      case 'size':
        $size=$_val;
        break;
    }
  }

  if (!isset($name))
  return '';

  $_html_result = '<select name="'.$name.'" id="'.$name.'" multiple="multiple">';
  if(is_array($value)){
    foreach($value as $v){
    		$_html_result .='<option class="selected" selected="selected" value="'.$v[0].'">'.$v[1].'</option>';
    }
  }
  $_html_result .='</select>';
  $_html_result .='<script type="text/javascript">
	$(document).ready(function()
        {
        $("#'.$name.'").fcbkcomplete({
			json_url: "'.$url.'",
        	cache: false,
        	filter_selected: true,
        	addontab: true,
        	maxshownitems:10,';
  if($max!=''){ $_html_result .='maxitimes:'.$max.','; }
  $_html_result .='complete_text:"Escribe para comenzar",
        	firstselected:true
	 	});';
    if($size!=''){ $_html_result .='$("#'.$name.' + ul").width('.$size.');'; }
    $_html_result.='});
    </script>
	';

  return $_html_result;
}
?>
