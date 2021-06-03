<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;

class Chat implements MessageComponentInterface
{
    //protected $clients;
    protected $user_id = array();

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn_wss, \Psr\Http\Message\RequestInterface $request = null)
    {
        $this->clients->attach($conn_wss);
        global $conn;
        parse_str($conn_wss->httpRequest->getUri()->getQuery(), $params);
        $api_key = $params["api_key"];
        $login = new Login($api_key);
        $process = $login->LoginAsApiKey();
        if ($login->error["status"]) {
            $this->user_id[$conn_wss->resourceId] = $login->getRes()["id"];
        }
        echo json_encode($this->user_id);
        // Store the new connection to send messages to later
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        global $conn;
        if (isset($this->user_id[$from->resourceId])) {
            // echo $this->user_id[$from->resourceId];
            $from_user = $this->user_id[$from->resourceId];
            echo $msg;
            $msg = json_decode($msg, true);
            $send_tos = array();
            if (isset($msg["type"]) && isset($msg["thread_id"])) {
                $data = array();
                $data["status"] = false;
                $thread_id = mysqli_real_escape_string($conn, $msg["thread_id"]);
                $thread = new Threads();
                $send_tos = $thread->getListUser($thread_id);
                if ($msg["type"] === "text") {
                    $message_text = mysqli_real_escape_string($conn, $msg["message_text"]);
                    if (!empty($message_text)) {
                        $message = new Messages();
                        $new_message = $message->newMessage($from_user, $thread_id, $message_text, "text");
                        if ($new_message) {
                            $idMessage = mysqli_insert_id($conn);
                            $data["status"] = true;
                            $data["thread_id"] = $thread_id;
                            $data["message"] = $message->getMessage($idMessage, $from_user);
                        } else {
                            $data["status"] = false;
                            $data["message"] = "Có lỗi khi gửi tin nhắn, vui lòng thử lại!";
                        }
                    } else {
                        $data["status"] = false;
                        $data["message"] = "Nội dung tin nhắn không được để trống";
                    }
                } elseif ($msg["type"] === "like") {
                    $message = new Messages();
                    $new_message = $message->newMessage($from_user, $thread_id, "", "like");
                    if ($new_message) {
                        $idMessage = mysqli_insert_id($conn);
                        $data["status"] = true;
                        $data["thread_id"] = $thread_id;
                        $data["message"] = $message->getMessage($idMessage, $from_user);
                    } else {
                        $data["status"] = false;
                        $data["message"] = "Có lỗi khi gửi tin nhắn, vui lòng thử lại!";
                    }
                } elseif ($msg["type"] === "file") {
                    $fileid = mysqli_real_escape_string($conn, $msg["attachment_id"]);
                    $message = new Messages();
                    $new_message = $message->newMessageFile($from_user, $thread_id, $fileid, "file");
                    if ($new_message) {
                        $idMessage = mysqli_insert_id($conn);
                        $data["status"] = true;
                        $data["thread_id"] = $thread_id;
                        $data["message"] = $message->getMessage($idMessage, $from_user);
                    } else {
                        $data["status"] = false;
                        $data["message"] = "Có lỗi khi gửi tin nhắn, vui lòng thử lại!";
                    }
                } elseif ($msg["type"] === "video_call") {
                    $data["status"] = true;
                    $data["thread_id"] = $thread_id;
                    $data["message"] = ["owner" => "me", "type" => "video_call", "reply" => $msg["reply"]];
                    if ($msg["reply"] == "send_uuid") {
                        $data["message"]["data_uuidd"] = $msg["data"];
                    }
                    $data["from"] = $from->resourceId;
                } elseif ($msg["type"] === "typing") {
                    $data["status"] = true;
                    $data["thread_id"] = $thread_id;
                    $data["message"] = ["owner" => "me", "type" => "typing"];
                }
                foreach ($this->clients as $client) {
                    $id_client = $this->user_id[$client->resourceId];
                    if (in_array($id_client, $send_tos)) {
                        $data_for_other_user = $data;
                        if ($data["status"]) {
                            $data_for_other_user["message"]["owner"] = "other";
                        }
                        if ($this->user_id[$from->resourceId] == $this->user_id[$client->resourceId])
                            $client->send(json_encode($data));
                        else
                            $client->send(json_encode($data_for_other_user));
                    }
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        unset($this->user_id[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
