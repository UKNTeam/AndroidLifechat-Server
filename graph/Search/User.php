<?php
session_start();
include("../../_connect.php");
include("../../_inc/Class.Login.php");
if (isset($_POST["api_key"]) && isset($_POST["q"])) {
    $api_key = mysqli_real_escape_string($conn, $_POST["api_key"]);
    $q = mysqli_real_escape_string($conn, $_POST["q"]);
    $login = new Login($api_key);
    $processs = $login->LoginAsApiKey();
    if ($login->error["status"]) {
        $_SESSION["api_key"] = $login->res["api_key"];
        $query = build_query($q);
        $res = mysqli_query($conn,$query);
        $data = array();
        $data["status"] = true;
        $data["data"] = array();
        while($row = mysqli_fetch_array($res)){
            array_push($data["data"],array("user_id"=>$row["id"],"username"=>$row["username"],"fullname"=>$row["fullname"], "avatar"=>$serverUrl."/storage/avatar/default.png","message"=>""));
        }
        echo json_encode($data);
        die;
    }
    echo json_encode($login->error);
}
function build_query($q)
{
    global $api_key;
    $count = explode(" ", $q);
    $build_sql = "";
    for ($i = 0; $i < count($count); $i++) {
        $char = $count[$i];
        if ($build_sql != "") $build_sql .= " UNION ALL ";
        $build_sql .= "SELECT * FROM table_accounts WHERE (`email` LIKE '%$char%' OR `fullname` LIKE '%$char%') AND api_key NOT LIKE '$api_key'";
    }
    $build_sql = "SELECT COUNT(*) as count_result, result.* FROM (" . $build_sql . ") AS result GROUP BY result.id ORDER BY count_result DESC LIMIT 30";
    return $build_sql;
}
