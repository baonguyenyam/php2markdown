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

<?php

include 'config.php';
$src = getcwd() .ROOT_DOCS;
$list = array('.');
$tmp = array_filter(glob('.'.ROOT_DOCS.'/*'), 'is_dir');
 foreach ($tmp as $key => $value) {
    array_push($list, pathinfo($value)['basename']);
 }

?>

    <?php include 'inc/header.php';?>


    <div class="container">
        <div class="row">
            <div class="col">


                <ul class="list-unstyled">

                    <?php

                    for ($i=0; $i < count($list); $i++) { 
                        echo '<li>';
                        if(is_dir($src .'/'. $list[$i])) {
                            $it = new RecursiveDirectoryIterator($src .'/'. $list[$i]);
                            $first = true;
                            foreach(new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CATCH_GET_CHILD) as $file) {
                                if ($file->getExtension() == 'md') {
                                    $lines = file( $file );
                                    $getFol = $file->getPathInfo()->getFilename() === '.' ? '/' : $list[$i] . '/';
                                    $getFil = $file->getFilename();
                                    if ( $first ) {
                                        echo '<h3 class="my-3 border-bottom pb-2">' .$getFol .'</h3>';
                                        echo '<ul class="list-unstyled mb-3">';
                                        $first = false;
                                    }
                                    ?>
                                            <li><a href="/edit?file=<?=$getFol?><?=$getFil?>"><?=$getFil?></a></li>
                                            <?php
                                }
                            }
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                    ?>
                </ul>


            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>