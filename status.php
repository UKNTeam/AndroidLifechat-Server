<?php
session_start();
$data = array("status" => false, "msg" => "Có lỗi khi kết nối với máy chủ!", "required_login" => false);
if (isset($_SESSION["user_id"])) {
    $data["status"] = true;
    $data["required_login"] = false;
} else {
    $data["msg"] = "Vui lòng đăng nhập";
    $data["required_login"] = true;
}
echo json_encode($data);
