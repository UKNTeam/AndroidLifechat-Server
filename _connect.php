<?php
include($_SERVER["DOCUMENT_ROOT"]."./_config.php");
$conn = new mysqli($db_server,$db_username,$db_password,$db_dbname);
if($conn->connect_errno){
    die("Failed connect to Mysql:".$mysqli -> connect_error);
}

?>