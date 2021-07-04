<?php
require_once 'inc/min.HTML.php';
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

<body>

    <?php include 'inc/header.php';?>

    <div class="ifMain container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link<?=getPath('')?>" href="/">
                                Homepage
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?=getPath('/about')?>" href="/about">
                                About
                            </a>
                        </li>
                        

                    </ul>

                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-4 markdown-body">

                <?php
                Route::add('/',function(){ 
                    getMarkDownFile('index');
                }, 'get');
                Route::add('/about/',function(){ 
                    getMarkDownFile('about/about');
                }, 'get');
                Route::add('/admin/',function(){ 
                    include 'admin.php';
                }, 'get');
                Route::add('/edit/',function(){ 
                    include 'edit.php';
                }, 'get');
                Route::add('/edit/',function(){ 
                    include 'edit.php';
                }, 'post');
                Route::add('/add/',function(){ 
                    include 'add.php';
                }, 'get');
                Route::add('/add/',function(){ 
                    include 'add.php';
                }, 'post');
                Route::add('/del/',function(){ 
                    include 'del.php';
                }, 'get');
                Route::add('/addfolder/',function(){ 
                    include 'addfolder.php';
                }, 'get');
                Route::add('/addfolder/',function(){ 
                    include 'addfolder.php';
                }, 'post');

                Route::run('/');

                ?>

            </main>
        </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/prism.js"></script>

</body>

</html>