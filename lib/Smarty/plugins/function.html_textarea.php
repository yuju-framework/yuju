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
function smarty_function_html_textarea($params, $template)
{
    $size = '';
    $max = '';
    $value = '';
    foreach ($params as $_key => $_val) {
        switch ($_key) {
            case 'name':
                $name = $_val;
                break;
            case 'size':
                $size = $_val;
                break;
            case 'max':
                $max = $_val;
                break;
            case 'class':
                $class = $_val;
                break;
            case 'value':
                $value = $_val;
                break;
        }
    }

    if (!isset($name))
        return '';

    $_html_result = '<textarea class="'.$class.'" name="' . $name . '"  size="' . $size . '" max="' . $max . '">' . $value . '</textarea>';
    return $_html_result;
}

?>
