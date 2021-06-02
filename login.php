<?php
session_start();
include("./_connect.php");
include("./_inc/Class.Login.php");
if(isset($_POST["account"]) && isset($_POST["password"])){
$account = mysqli_real_escape_string($conn,$_POST["account"]);
$password = md5($_POST["password"]);
$login = new Login($account,$password);
$processs = $login->Login();
if($login->error["status"]){
    $_SESSION["api_key"] = $login->res["api_key"];
}
echo json_encode($login->error);
}
