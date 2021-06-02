<?php
session_start();
include("../../_connect.php");
include("../../_inc/Class.messages.php");
include("../../_inc/Class.Login.php");
include("../../_inc/Class.threads.php");
include("../../_inc/Class.Info.php");
if (isset($_POST["api_key"]) && isset($_POST["thread_id"]) && isset($_POST["message_text"]) && isset($_POST["type"])) {
    $api_key = mysqli_real_escape_string($conn, $_POST["api_key"]);
    $thread_id = mysqli_real_escape_string($conn, $_POST["thread_id"]);
    $message_text = mysqli_real_escape_string($conn, $_POST["message_text"]);
    $type = $_POST["type"];
    $login = new Login($api_key);
    $processs = $login->LoginAsApiKey();
    $my_id = $login->getRes()["id"];
    if ($login->error["status"]) {
        $data = array();
        $data["status"] = false;
        $_SESSION["api_key"] = $login->res["api_key"];
        if ($type == "text") {
            if (!empty($message_text)) {
                $message = new Messages();
                $new_message = $message->newMessage($my_id, $thread_id, $message_text, "text");
                if ($new_message) {
                    $idMessage = mysqli_insert_id($conn);
                    $data["status"] = true;
                    $data["message"] = $message->getMessage($idMessage,$my_id);
                } else {
                    $data["status"] = false;
                    $data["message"] = "Có lỗi khi gửi tin nhắn, vui lòng thử lại!";
                }
            } else {
                $data["status"] = false;
                $data["message"] = "Nội dung tin nhắn không được để trống";
            }
        }
        echo json_encode($data);
        die;
    }
    echo json_encode($login->error);
}
