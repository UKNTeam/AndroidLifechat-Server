<?php
include("./_connect.php");
include("./_inc/Class.Login.php");
if (isset($_FILES["file"]) && isset($_GET["api_key"])) {
    $file = $_FILES["file"];
    $namefile = mysqli_real_escape_string($conn, $file["name"]);
    $apikey = mysqli_real_escape_string($conn, $_GET["api_key"]);
    $login = new Login($apikey);
    $proccess = $login->LoginAsApiKey();
    $my_id = $login->getRes()["id"];
    if ($login->error["status"]) {
        if (empty($namefile))
            $namefile = "unknownamefile";
        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        if(empty($extension))
        $extension = "unknow";
        if ($file["error"] == 0) { //upload successfully
            $now = getdate()[0];
            $absolute_path = "/storage/public/fileupload_$now.$extension";
            if (move_uploaded_file($file["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . $absolute_path)) {
                $array_extension_image = array("jpg", "jpeg", "png", "gif", "webp", "bwp");
                $array_extension_video = array("webm", "mkv", "flv", "avi", "wmv", "3gp", "mp4");
                if (in_array($extension, $array_extension_image))
                    $type = "image";
                elseif (in_array($extension, $array_extension_video))
                    $type = "video";
                else
                    $type = "file";
                $res = mysqli_query($conn, "INSERT INTO table_attachments (`filename`,`filetype`,`owner`,`urlfile`) VALUES ('$namefile','$type','$my_id','$absolute_path')");
                $fileid = mysqli_insert_id($conn);
                if ($res) {
                    echo json_encode(array("status" => true, "file_id" => $fileid));
                } else {
                    echo json_encode(array("status" => false, "message" => "Có lỗi khi upload file, vui lòng thử lại sau"));
                }
            } else {
                echo json_encode(array("status" => false, "message" => "Có lỗi khi upload file, vui lòng thử lại sau"));
            }
        } else {
            echo json_encode(array("status" => false, "message" => "Có lỗi khi upload file, vui lòng thử lại sau"));
        }
    } else {
        echo json_encode(array("status" => false, "message" => "API KEY không hợp lệ, vui lòng đăng nhập lại!"));
    }
}
