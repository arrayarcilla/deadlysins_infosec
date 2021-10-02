<?php
//start sesh
session_start();

//if already logged in, redirect to welcome
if (isset($_SESSION["userid"]) && $_SESSION["userid"] === true) {
    header("location: welcome.php");
    exit;
}
?>