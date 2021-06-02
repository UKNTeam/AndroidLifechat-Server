<?php
session_start();
include("./_connect.php");
include("./_inc/Class.Regsister.php");
include("./_inc/_functions.php");
if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["fullname"]) && isset($_POST["password"])){
$username = mysqli_real_escape_string($conn,$_POST["username"]);
$email = mysqli_real_escape_string($conn,$_POST["email"]);
$fullname = mysqli_real_escape_string($conn,$_POST["fullname"]);
$password = md5($_POST["password"]);
$regsister = new Regsister($username,$email,$fullname,$password);
if($regsister->error["status"]){
    include("./_inc/Class.Login.php");
    $login = new Login($email,$password);
    $processs = $login->Login();
    if($login->error["status"]){
        $_SESSION["id"] = $login->res["id"];
    }
}
echo json_encode($regsister->error);
}
?>