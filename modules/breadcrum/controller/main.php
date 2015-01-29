<?php 
    
    global $view;

    $parent="";
    $array[$view->getName()] = $view->getTitle();
    while($parent!="index"){
        $parent=$view->getParent();
        $view->load($parent);
        $array[$parent]=$view->getTitle();
    }

    $array["index"]=$params["index"];
    $array = array_reverse($array);
   
    $template->assignByRef('href',$array);
    
?>