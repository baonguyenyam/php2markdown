<?php
function str_contains(string $haystack, string $needle): bool {
    return '' === $needle || false !== strpos($haystack, $needle);
}
function getPath($name) {
    $get_Query = isset($_GET['read']) ? $_GET['read'] : '/index';
    if($name === $get_Query) {
        return ' active';
    }
}
function getPathOrder($name) {
    $f = fopen('.'. ROOT_DOCS .'/'.$name .'.md', 'r');
    $line = fgets($f);
    fclose($f);
    if (str_contains($line, "<!--//") && str_contains($line, "//-->")) {
        preg_match_all("/<!--\/\/(.*?)\/\/-->/",$line,$out);
        $getval = explode(",",$out[1][0]);
        return 'style="order:'.$getval[1].'"';
    } else {
        return 'style="order:999999"';
    }
}
function getPathName($name) {
    $f = fopen('.'. ROOT_DOCS .'/'.$name .'.md', 'r');
    $line = fgets($f);
    fclose($f);
    if (str_contains($line, "<!--//") && str_contains($line, "//-->")) {
        preg_match_all("/<!--\/\/(.*?)\/\/-->/",$line,$out);
        $getval = explode(",",$out[1][0]);
        return $getval[0];
    } else {
        // return substr($name, strrpos($name, "/" )+1);
        return $name;
    }
}
function getMarkDownFile() {
    $get_Query = isset($_GET['read']) ? $_GET['read'] : '/';
    $Parsedown = new Parsedown();
    if(isset($get_Query) && $get_Query === '/') {
        $file = 'index.md';
    }else if(isset($get_Query) && $get_Query !== '/') {
        $file = $get_Query.'.md';
    }else {
        $file = null;
    }
    if(!@file_get_contents('.'. ROOT_DOCS .'/'.$file)) {
        echo 'File not found';
    } else {
        echo $Parsedown->text(file_get_contents('.'. ROOT_DOCS .'/'.$file));
    }
}
function getDirContents($dir, &$results = array()) {
    $files = scandir($dir,SCANDIR_SORT_DESCENDING);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if($ext === 'md') {
                $results[$key]['name'] = pathinfo($path, PATHINFO_FILENAME);
                $results[$key]['fullname'] = pathinfo($path, PATHINFO_BASENAME);
                if( '/'.basename($dir) === ROOT_DOCS) {
                    $results[$key]['dir'] = '';
                } else {
                    $results[$key]['dir'] = basename($dir);
                }
            }
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results[$key]);
            // $results[] = $path;
        }
    }
    return $results;
}