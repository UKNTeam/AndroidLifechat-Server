<?php
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_dbname = "lifechat";
date_default_timezone_set("Asia/Ho_Chi_Minh");
if(isset($_SERVER["REQUEST_SCHEME"]) && isset($_SERVER["HTTP_HOST"]))
$serverUrl = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"]
?>