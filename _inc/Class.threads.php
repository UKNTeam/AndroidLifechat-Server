<?php
class Threads
{
    public $user_id;
    public $result = array("status" => false, "msg" => "Something went wrong!");
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
    }
    public function getListThreads()
    {
        global $conn;
        global $serverUrl;
        $res = mysqli_query($conn, "SELECT table_threads.* FROM table_threads WHERE table_threads.user_id = '$this->user_id' OR table_threads.user_id_invite = '$this->user_id' ORDER BY table_threads.last_update DESC");
        $data_list = array();
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_array($res)) {
                $res_ss = mysqli_query($conn, "SELECT table_messages.message, table_messages.options FROM table_messages WHERE table_messages.id_thread = '" . $row["id"] . "' ORDER BY table_messages.create_time DESC LIMIT 1");
                $row_message = mysqli_fetch_assoc($res_ss);
                $user_id_target = $row["user_id"];
                if ($user_id_target == $this->user_id)
                    $user_id_target = $row["user_id_invite"];
                $info_target = new Info($user_id_target);
                $info = $info_target->getData();
                $options = json_decode($row_message["options"], true);
                if ($options["type"] == "text")
                    $message = $row_message["message"];
                elseif ($options["type"] == "like")
                    $message = "Đã gửi một biểu tượng cảm xúc";
                elseif ($options["type"] == "file")
                    $message = "Đã gửi một đính kèm";
                array_push($data_list, array("username" => $info["username"], "avatar" => $serverUrl . "/storage/avatar/default.png", "fullname" => $info["fullname"], "email" => $info["email"], "user_id" => $info["id"], "thread_id" => $row["id"], "last_message" => $message, "update_time" => $row["last_update"]));
            }
        }
        $this->result["status"] = true;
        $this->result["data"] = $data_list;
    }
    public function checkThread($user_id_target)
    {
        global $conn;

        $res = mysqli_query($conn, "SELECT * FROM table_threads WHERE (user_id = '$this->user_id' AND user_id_invite = '$user_id_target') OR (user_id_invite = '$this->user_id' AND user_id = '$user_id_target') ORDER BY last_update DESC");
        return mysqli_num_rows($res);
    }
    public function createThread($user_id_target)
    {
        global $conn;
        $res = mysqli_query($conn, "INSERT INTO table_threads (`user_id`,`user_id_invite`) VALUES ('$this->user_id','$user_id_target')");
        return $res;
    }
    public function getThreadData($user_id_target)
    {
        global $conn;
        $res = mysqli_query($conn, "SELECT * FROM table_threads WHERE (user_id = '$this->user_id' AND user_id_invite = '$user_id_target') OR (user_id_invite = '$this->user_id' AND user_id = '$user_id_target') LIMIT 1");
        return mysqli_fetch_assoc($res);
    }
}
