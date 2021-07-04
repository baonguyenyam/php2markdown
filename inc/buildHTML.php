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
function getMarkDownFileRePo() {
    $get_Repo = isset($_GET['repo']) ? $_GET['repo'] : ROOT_API_URL. '/index.md';
    $get_Query = isset($_GET['read']) ? $_GET['read'] : '/';
    $Parsedown = new Parsedown();
    if(isset($get_Query) && $get_Query === '/') {
        $file = ROOT_API_ROOT_RAW. '/index.md';
    }else if(isset($get_Query) && $get_Query !== '/') {
        $file = $get_Query;
    }else {
        $file = null;
    }
    if(!@file_get_contents($file)) {
        echo 'File not found';
    } else {
        echo $Parsedown->text(file_get_contents($file));
    }

    echo '<p>URL: <a href="'.$get_Repo.'">'.$get_Repo.'</a></p>';
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
    // var_dump(shell_exec('curl -i -u '.GITHUB_USER.':'.GITHUB_TOKEN.' https://api.github.com/users/'.GITHUB_USER));
    // var_dump(shell_exec('curl -i -H "Authorization: token '.GITHUB_TOKEN.'" https://api.github.com/users/'.GITHUB_USER));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "php/curl");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POST  , true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/vnd.github.v3+json',
        'Authorization: token '.GITHUB_TOKEN
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function buildGitRepoMenu() {
    $data = buildGitRepo();
    foreach ($data as $key => $value) {
        echo '<li class="nav-item"'.buildGitRepoOrder($value).'><a class="nav-link'.buildGitRepoActive($value).'" href="/?read='.buildGitRepoLink($value).'&repo='.buildGitRepoLinkFull($value).'">'.buildGitRepoName($value).'</a></li>';
    }
}
function buildGitRepoLinkFull($value) {
    return $value['html_url'];
}
function buildGitRepoLink($value) {
    return $value['download_url'];
}
function buildGitRepoActive($value) {
    $get_Query = isset($_GET['read']) ? $_GET['read'] : ROOT_API_ROOT_RAW. '/index.md';
    $path = $value['download_url'];
    if($path === $get_Query) {
        return ' active';
    }
}
function buildGitRepoName($value) {
    $html = getHtml($value['download_url']);
    $line = preg_split('#\r?\n#', ltrim($html), 0)[0];
    if (str_contains($line, "<!--//") && str_contains($line, "//-->")) {
        preg_match_all("/<!--\/\/(.*?)\/\/-->/",$line,$out);
        $getval = explode(",",$out[1][0]);
        return $getval[0];
    } else {
        return $value['name'];
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
    $loop = 0;
    foreach ($json as $key => $value) {
        if($json[$key]->type === 'dir') {
            $html2 = getHtml($json[$key]->url);
            $json2 = json_decode($html2);
            foreach ($json2 as $key2 => $value2) {
                if($json2[$key2]->type === 'file') {
                    $variable2 = substr($json2[$key2]->path, strlen(ROOT_DOCS));
                    $menu[$loop]['name'] = $json2[$key2]->name;
                    $menu[$loop]['path'] = substr($variable2, 0, strrpos($variable2, "/")) . '/';
                    $menu[$loop]['html_url'] = $json2[$key2]->html_url;
                    $menu[$loop]['url'] = $json2[$key2]->url;
                    $menu[$loop]['download_url'] = $json2[$key2]->download_url;
                }
                $loop++;
            }
        } else {
            $variable = substr($json[$key]->path, strlen(ROOT_DOCS));
            $menu[$loop]['name'] = $json[$key]->name;
            $menu[$loop]['path'] = substr($variable, 0, strrpos($variable, "/")) . '/';
            $menu[$loop]['html_url'] = $json[$key]->html_url;
            $menu[$loop]['url'] = $json[$key]->url;
            $menu[$loop]['download_url'] = $json[$key]->download_url;
        }
        $loop++;
    }
    return $menu;
}