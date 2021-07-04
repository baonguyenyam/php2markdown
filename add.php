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
    <title><?=ROOT_DOCS_NAME?></title>
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

            file_put_contents('./'. ROOT_DOCS .'/'.$_POST['file'] . trim($_POST['name']) . '.md', $_POST['source']);
            header('Location: /');
        }

    ?>

    <div class="container">
        <div class="row">
            <div class="col py-4">

                <form action="" method="post">

                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="File name"
                            aria-label="File name" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">.md</span>
                    </div>
                    <input name="file" type="hidden" value="<?=isset($getFile)?$getFile:''?>">

                    <div class="my-3">
                        <textarea name="source" id="source" cols="30" rows="40" class="form-control">&lt;!--//Home Page,1//--&gt;
</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Create content</button>
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
        extraKeys: {
            "Enter": "newlineAndIndentContinueMarkdownList"
        }
    });
    editor.setOption("theme", 'monokai')
    editor.setSize(null, 750);
    </script>

</body>

</html>