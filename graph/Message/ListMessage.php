<?php
session_start();
include("../../_connect.php");
include("../../_inc/Class.messages.php");
include("../../_inc/Class.Login.php");
include("../../_inc/Class.threads.php");
include("../../_inc/Class.Info.php");
if (isset($_POST["api_key"]) && isset($_POST["user_id"])) {
    $api_key = mysqli_real_escape_string($conn, $_POST["api_key"]);
    $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
    $login = new Login($api_key);
    $processs = $login->LoginAsApiKey();
    $my_id = $login->getRes()["id"];
    if ($login->error["status"]) {
        $data = array();
        $data["status"] = false;
        $_SESSION["api_key"] = $login->res["api_key"];
        $thread = new Threads($my_id);
        if($thread->checkThread($user_id)){
            $data = getThread($thread,$user_id);
        }
        else{
            if($thread->createThread($user_id)){
                $data = getThread($thread,$user_id);
            }else{
               $data["status"] = false;
               $data["message"] = "Có lỗi khi tạo mới đoạn hội thoại!";
            }
        }
        echo json_encode($data);
        die;
    }
    echo json_encode($login->error);
}
function getThread($thread,$user_id){
    global $serverUrl;
    global $my_id;
    $threadData = $thread->getThreadData($user_id);
    $infoTarget = new Info($user_id);
    $infoTargetData = $infoTarget->getData();
    $message = new Messages($threadData["id"]);
    $data["status"] = true;
    $data["thread_id"] = $threadData["id"];
    $data["user"] = array("user_id"=>$infoTargetData["id"],"username"=>$infoTargetData["username"],"avatar"=>$serverUrl."/storage/avatar/default.png","fullname"=>$infoTargetData["fullname"]);
    $data["messages"] = $message->getListMessages($my_id);
    return $data;
}
