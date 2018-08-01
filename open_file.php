<?php
    session_start();
    if(!(isset($_SESSION['username']))){
    header("Location: first_page.php");
    exit;
    }
    $_SESSION['file_to_open'] = $_GET['file_to_open'];
    $file = $_SESSION['file_to_open'];
    //if(!preg_match('/^[\w_\.\-]+$/', $filename )){
    //    echo "Invalid filename";
    //    exit;
    //}
    $username = $_SESSION['username'];
    $full_path = sprintf("/home/asantrach/uploads/%s/%s", $username, $file);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($full_path);
    //$content = mime_content_type($full_path);
    //header("Content-Type: ".$mime);
    //readfile($full_path);

    header('Content-type: '.$mime); 
    header('Content-Length: ' . filesize($full_path));
    readfile($full_path);
    exit;
?>