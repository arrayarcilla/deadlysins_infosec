<?php

/*connect to sql db*/
$db = mysqli_connect('localhost', 'root', '', 'sins');

if($db === false){
    die("Error: connection error. " . mysqli_connect_error());

}

?>