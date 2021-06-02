<?php
session_start();
include("../../_connect.php");
include("../../_inc/Class.threads.php");
include("../../_inc/Class.Login.php");
include("../../_inc/Class.Info.php");
if (isset($_POST["api_key"])) {
    $api_key = mysqli_real_escape_string($conn, $_POST["api_key"]);
    $login = new Login($api_key);
    $processs = $login->LoginAsApiKey();
    $my_id = $login->getRes()["id"];
    if ($login->error["status"]) {
        $threads = new Threads($my_id);
        $threads->getListThreads();
        echo json_encode($threads->result);
    }
}
