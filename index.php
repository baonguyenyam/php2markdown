<?php
require_once 'config.php';
require_once 'inc/route.php';
require_once 'inc/Parsedown.php';
require_once 'inc/buildHTML.php';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Nguyen Pham">
    <title>Dev Docs</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/github-markdown.css" rel="stylesheet">
    <link href="/assets/css/dist/style.min.css" rel="stylesheet">
    <link href="/assets/css/prism.css" rel="stylesheet">
</head>
<?php


if(GITHUB_ENABLE) {
    $path = ROOT_API_ROOT_DOCS;    
} else {
    $path = './'. ROOT_DOCS . '/';
    $list = getDirContents($path);
}

?>
<body>

    <?php include 'inc/header.php';?>

    <div class="ifMain container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">


                    

                    <ul class="nav flex-column">

                        <?php

                        if(GITHUB_ENABLE) {
                            buildGitRepoMenu();
                        } else {
                            foreach ($list as $key => $value) {
                                if(isset($list[$key][0])) {
                                    echo '<li class="nav-item"'.getPathOrder($list[$key][0]['dir'].'/'.$list[$key][0]['name']).'><a class="nav-link'.getPath($list[$key][0]['dir'].'/'.$list[$key][0]['name']).'" href="/?read='.$list[$key][0]['dir'].'/'.$list[$key][0]['name'].'">'.getPathName($list[$key][0]['dir'].'/'.$list[$key][0]['name']).'</a></li>';
                                } else {
                                    echo '<li class="nav-item"'.getPathOrder($list[$key]['dir'].'/'.$list[$key]['name']).'><a class="nav-link'.getPath($list[$key]['dir'].'/'.$list[$key]['name']).'" href="/?read='.$list[$key]['dir'].'/'.$list[$key]['name'].'">'.getPathName($list[$key]['dir'].'/'.$list[$key]['name']).'</a></li>';
                                }
                            }
                        }
                        ?>
                        

                    </ul>

                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-4 markdown-body">

                <?php

                if(GITHUB_ENABLE) {
                    Route::add('/',function(){
                        getMarkDownFileRePo();
                    }, 'get');
                } else {
                    Route::add('/',function(){ 
                        getMarkDownFile();
                    }, 'get');
                    Route::add('/admin',function(){ 
                        include 'admin.php';
                    }, 'get');
                    Route::add('/edit',function(){ 
                        include 'edit.php';
                    }, 'get');
                    Route::add('/edit',function(){ 
                        include 'edit.php';
                    }, 'post');
                    Route::add('/add',function(){ 
                        include 'add.php';
                    }, 'get');
                    Route::add('/add',function(){ 
                        include 'add.php';
                    }, 'post');
                    Route::add('/del',function(){ 
                        include 'del.php';
                    }, 'get');
                    Route::add('/addfolder',function(){ 
                        include 'addfolder.php';
                    }, 'get');
                    Route::add('/addfolder',function(){ 
                        include 'addfolder.php';
                    }, 'post');
                }

                Route::run('/');

                ?>

            </main>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/prism.js"></script>


</body>

</html>