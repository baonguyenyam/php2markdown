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
        $getFile = isset($_GET['file']) ? $_GET['file'] : '';
        $file = @file_get_contents('./'. ROOT_DOCS .'/'.$getFile);
        !$file ? header('Location: /') : null;

        if(!empty($_POST)) {
            file_put_contents('./'. ROOT_DOCS .'/'.$_POST['file'], $_POST['source']);
            header('Location: /edit?file='.$_POST['file']);
        }

    ?>

    <div class="container">
        <div class="row">
            <div class="col py-4">

                <form action="" method="post">

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update content</button>
                    <input name="file" type="hidden" value="<?=isset($getFile)?$getFile:$_POST['file']?>">
                </div>

                <div class="my-3">
                    <textarea name="source" id="source" cols="30" rows="40" class="form-control"><?=$file?></textarea>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update content</button>
                </div>


                </form>


            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/codemirror.min.js"></script>
    <script src="/assets/js/mode/xml/xml.js"></script>
    <script src="/assets/js/mode/markdown/markdown.js"></script>

    <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("source"), {
        mode: "markdown",
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        lineWrapping: true,
        smartIndent: true,
        indentWithTabs: true,
        extraKeys: {"Enter": "newlineAndIndentContinueMarkdownList"}
    });
    editor.setOption("theme", 'monokai')
    editor.setSize(null, 750);
    </script>

</body>

</html>