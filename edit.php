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

                    <div class="d-flex justify-content-between  align-items-center ">
                        <div class="input-group me-3" style="max-width: 500px">
                            <input type="file" class="form-control" name="uploadfile" id="uploadfile">
                            <button class="btn btn-outline-secondary" type="button" id="doUpload">Button</button>
                        </div>

                        <div class="text-end ml-auto text-nowrap">
                            <button type="submit" class="btn btn-primary">Update content</button>
                            <input name="file" type="hidden" value="<?=isset($getFile)?$getFile:$_POST['file']?>">
                        </div>

                    </div>
                    <div class="my-3">
                        <textarea name="source" id="source" cols="30" rows="40"
                            class="form-control"><?=$file?></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update content</button>
                    </div>


                </form>


            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/codemirror.min.js"></script>
    <script src="/assets/js/mode/xml/xml.js"></script>
    <script src="/assets/js/mode/markdown/markdown.js"></script>

    <script>
    function insertText(data) {
        var cm = editor;
        var doc = cm.getDoc();
        var cursor = doc.getCursor(); // gets the line number in the cursor position
        var line = doc.getLine(cursor.line); // get the line contents
        var pos = {
            line: cursor.line
        };
        if (line.length === 0) {
            doc.replaceRange(data, pos);
        } else {
            doc.replaceRange("\n" + data, pos);
        }
    }

    $('#doUpload').on('click', function() {
        var file_data = $('#uploadfile').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        $.ajax({
            url: 'upload', // <-- point to server-side PHP script 
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(php_script_response){
                insertText('![ALT]('+php_script_response+' "Title")');
            }
        });
    })
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