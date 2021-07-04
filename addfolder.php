<?php

include 'config.php';

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
    <link href="/assets/css/codemirror.min.css" rel="stylesheet">
    <link href="/assets/css/theme/monokai.css" rel="stylesheet">
</head>

<body>

    <?php include 'inc/header.php';?>

    <?php
        $getFile = isset($_GET['to']) ? $_GET['to'] : '';
        if(!empty($_POST)) {
            mkdir('.'. ROOT_DOCS .'/'.$_POST['file'] . trim($_POST['name']));
            header('Location: /');
        }

    ?>

    <div class="container">
        <div class="row">
            <div class="col py-4">

                <form action="" method="post">

                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Folder name"
                            aria-label="Folder name" aria-describedby="basic-addon2">
                    </div>
                    <input name="file" type="hidden" value="<?=isset($getFile)?$getFile:''?>">

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Create folder</button>
                    </div>


                </form>


            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>


</body>

</html>