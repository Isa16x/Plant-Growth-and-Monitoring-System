<?php
 if (!isset($_SESSION)) {
    session_start();
    }
    

function redirect($url) {
    header('Location: '.$url);
    die();
}


session_unset();
session_destroy();

redirect('index.php');


die();

?>
