<?php
//start sesh
session_start();

//destroy sesh
if (session_destroy()) {
    //redirect to index
    header("Location: index.php");
    exit;
}
?>