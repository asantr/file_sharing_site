<?php
    session_start();
//    destroy that session and send to the front 
    session_destroy();
    header("Location: first_page.php");
    exit;

?>