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
    $f = fopen('./'. ROOT_DOCS .'/'.$name .'.md', 'r');
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
    $f = fopen('./'. ROOT_DOCS .'/'.$name .'.md', 'r');
    $line = fgets($f);
    fclose($f);
    if (str_contains($line, "<!--//") && str_contains($line, "//-->")) {
        preg_match_all("/<!--\/\/(.*?)\/\/-->/",$line,$out);
        $getval = explode(",",$out[1][0]);
        return $getval[0];
    } else {
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
    if(!@file_get_contents('./'. ROOT_DOCS .'/'.$file)) {
        echo 'File not found';
    } else {
        echo $Parsedown->text(file_get_contents('./'. ROOT_DOCS .'/'.$file));
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
                if( basename($dir) === ROOT_DOCS) {
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
function getHtml($url, $post = null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.141 Safari/537.36';
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml', 'User-Agent:Php/Ayan Dhara'));
    curl_setopt($ch, CURLOPT_USERPWD, GITHUB_USER . ":" . GITHUB_TOKEN);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    if (!empty($post)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
    }

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function buildGitRepoMenu() {
    $data = buildGitRepo();
    foreach ($data as $key => $value) {
        echo '<li class="nav-item"'.buildGitRepoOrder($value).'><a class="nav-link" href="">'.buildGitRepoName($value).'</a></li>';
    }
}
function buildGitRepoName($value) {
    $html = getHtml($value['download_url']);
    $line = preg_split('#\r?\n#', ltrim($html), 0)[0];
    // var_dump($value);
    if (str_contains($line, "<!--//") && str_contains($line, "//-->")) {
        preg_match_all("/<!--\/\/(.*?)\/\/-->/",$line,$out);
        $getval = explode(",",$out[1][0]);
        return $getval[0];
    } else {
        // return $value['name'];
    }
}
function buildGitRepoOrder($value) {
    $html = getHtml($value['download_url']);
    $line = preg_split('#\r?\n#', ltrim($html), 0)[0];
    if (str_contains($line, "<!--//") && str_contains($line, "//-->")) {
        preg_match_all("/<!--\/\/(.*?)\/\/-->/",$line,$out);
        $getval = explode(",",$out[1][0]);
        return 'style="order:'.$getval[1].'"';
    } else {
        return 'style="order:999999"';
    }
}
function buildGitRepo() {
    $html = getHtml(ROOT_API_ROOT_DOCS);
    $json = json_decode($html);
    $menu = array();
    foreach ($json as $key => $value) {
        if($json[$key]->type === 'dir') {
            $html2 = getHtml($json[$key]->url);
            $json2 = json_decode($html2);
            foreach ($json2 as $key2 => $value2) {
                if($json2[$key2]->type === 'file') {
                    $variable2 = substr($json2[$key2]->path, strlen(ROOT_DOCS));
                    $menu[$key2]['name'] = $json2[$key2]->name;
                    $menu[$key2]['path'] = substr($variable2, 0, strrpos($variable2, "/")) . '/';
                    $menu[$key2]['html_url'] = $json2[$key2]->html_url;
                    $menu[$key2]['url'] = $json2[$key2]->url;
                    $menu[$key2]['download_url'] = $json2[$key2]->download_url;
                }
            }
        } else {
            $variable = substr($json[$key]->path, strlen(ROOT_DOCS));
            $menu[$key]['name'] = $json[$key]->name;
            $menu[$key]['path'] = substr($variable, 0, strrpos($variable, "/")) . '/';
            $menu[$key]['html_url'] = $json[$key]->html_url;
            $menu[$key]['url'] = $json[$key]->url;
            $menu[$key]['download_url'] = $json[$key]->download_url;
        }
    }
    return $menu;
}