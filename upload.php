<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
if(isset($_POST)){
    $allowed_types = array('png','bmp','jpg','gif');
    $name=$_FILES['file']['name'];
    $size=$_FILES['file']['size'];
    $type=$_FILES['file']['type'];
    $temp=$_FILES['file']['tmp_name'];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $nn = pathinfo($name, PATHINFO_FILENAME);
    $fname = $nn.uniqid().'.'.$ext;
    if (in_array(strtolower($ext), $allowed_types)) {
        $move =  move_uploaded_file($temp,"uploads/".$fname);
        echo $actual_link. "/uploads/".$fname;
    }
}
?>