<?php
class Messages
{
    public $id_thread;
    public $result = array("status" => false, "msg" => "Something went wrong!");
    public function __construct($id_thread = null)
    {
        $this->id_thread = $id_thread;
    }
    public function getListMessages($user_id)
    {
        global $conn;

        $res = mysqli_query($conn, "SELECT table_attachments.urlfile, table_attachments.filetype, table_attachments.filename, table_messages.* FROM `table_messages` LEFT JOIN table_attachments ON table_messages.attachment_id = table_attachments.id WHERE table_messages.id_thread = '$this->id_thread' ORDER BY table_messages.create_time ASC");
        $data_list = array();
        if (mysqli_num_rows($res)) {
            while ($row = mysqli_fetch_array($res)) {
                array_push($data_list, $this->renderMessage($row, $user_id));
            }
        }
        $this->result["status"] = true;
        $this->result["data"] = $data_list;
        return $data_list;
    }
    public function newMessage($user_send, $thread_id, $message, $type = "text")
    {
        global $conn;
        $options = array();
        $options["type"] = $type;
        $options_raw = json_encode($options);
        $res = mysqli_query($conn, "INSERT INTO table_messages (`id_thread`,`user_send`,`message`,`options`) VALUES ('$thread_id','$user_send','$message','$options_raw')");
        return $res;
    }
    public function newMessageFile($user_send, $thread_id, $file_id, $type = "file")
    {
        global $conn;
        $options = array();
        $options["type"] = $type;
        $options_raw = json_encode($options);
        $res = mysqli_query($conn, "INSERT INTO table_messages (`id_thread`,`user_send`,`attachment_id`,`options`) VALUES ('$thread_id','$user_send','$file_id','$options_raw')");
        return $res;
    }
    public function getMessage($message_id, $user_id)
    {
        global $conn;
        $res = mysqli_query($conn, "SELECT table_attachments.urlfile, table_attachments.filetype,table_attachments.filename, table_messages.* FROM `table_messages` LEFT JOIN table_attachments ON table_messages.attachment_id = table_attachments.id WHERE table_messages.id = '$message_id'");
        $row = mysqli_fetch_assoc($res);
        return $this->renderMessage($row, $user_id);
    }
    public function renderMessage($row, $user_id)
    {
        global $serverUrl;
        if (isset($row["urlfile"]))
            $urlfile = $serverUrl.$row["urlfile"];
        else
            $urlfile = "";
        if (isset($row["filetype"]))
            $filetype = $row["filetype"];
        else
            $filetype = "";
        if (isset($row["filename"]))
            $filename = $row["filename"];
        else
            $filename = "";
        $option = $row["options"];
        $option = json_decode($option,true);
        $option["auto_host"] = false;
        if(empty($serverUrl))
            $option["auto_host"] = true;
        $option = json_encode($option);
        $arr = array("message_id" => $row["id"], "message" => $row["message"], "options" => $option, "create_time" => $row["create_time"], "url_file" => $urlfile,"file_type"=>$filetype, "file_name"=>$filename);
        $arr["owner"] = $user_id == $row["user_send"] ? "me" : "other";
        return $arr;
    }
}
