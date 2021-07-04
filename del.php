<?php

include 'config.php';

?>


<?php
    $getFile = isset($_GET['file']) ? $_GET['file'] : '';
    $file = '.'. ROOT_DOCS .'/'.$getFile;
    !file_exists($file) ? header('Location: /') : null;
    unlink($file);
    header('Location: /');

?>

    