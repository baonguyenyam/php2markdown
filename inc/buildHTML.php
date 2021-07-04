<?php
function getPath($name) {
    $url = $_SERVER['REQUEST_URI'];
    $path = isset($name) ? $name.'/' : '/';
    if($path === parse_url($url, PHP_URL_PATH)) {
        echo ' active';
    }
}
function getMarkDownFile($name) {
    $Parsedown = new Parsedown();
    $file = isset($name) ? $name.'.md' : null;
    if(!@file_get_contents('.'. ROOT_DOCS .'/'.$file)) {
        echo 'File not found';
    } else {
        echo $Parsedown->text(file_get_contents('.'. ROOT_DOCS .'/'.$file));
    }
}