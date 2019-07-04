<?php

function my_get_template_part($template, $data = array()){
    extract($data);
    require locate_template($template.'.php');
}


function filter_function_name($title) {



            $title = "DDD";


    return $title;
}

add_filter( 'wp_title', 'filter_function_name', 10, 2 );



















