<?php
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
</head>

<body>

    <header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap shadow-sm navbar-expand-md">
        <a class="navbar-brand col-md-3 col-lg-2 col-xl-auto me-0 px-3" href="/">MENU</a>
        <button class="navbar-toggler d-md-none me-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="ml-auto justify-content-end collapse navbar-collapse">
            <ul class="navbar-nav px-3 d-none d-md-flex align-items-center">
                <li class="nav-item me-2">
                    <div class="badge bg-danger rounded-pill py-2 px-3">v1.0.2</div>
                </li>
            </ul>
        </div>
    </header>

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

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 markdown-body">

                <?php
                Route::add('/',function(){ 
                    getMarkDownFile('index');
                }, 'get');
                Route::add('/about/',function(){ 
                    getMarkDownFile('_about/about');
                }, 'get');

                Route::run('/');

                ?>

            </main>
        </div>
    </div>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>