<?php
class Regsister
{
    public $username;
    public $email;
    public $fullname;
    public $password;
    public $api_key;
    public $error = array("status" => false, "msg" => "Something went wrong!");
    public function __construct($username, $email, $fullname, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->Regsister();
    }
    public function Regsister()
    {
        global $conn;
        $username = $this->username;
        $email = $this->email;
        $fullname = $this->fullname;
        $password = $this->password;
        $api_key = "EAA".generateRandomString(25);
        if (!empty($username) && !empty($email) && !empty($fullname) && !empty($password)) {
            if (strlen($password) >= 8) {
                if (mysqli_query($conn, "INSERT INTO table_accounts (`username`,`email`,`fullname`,`password`,`api_key`) VALUES ('$username','$email','$fullname','$password','$api_key')")) {
                    $this->error["status"] = true;
                    $this->error["msg"] = "Đăng ký thành công!";
                    $this->error["api_key"] = $api_key;
                } else {
                    $this->error["status"] = false;
                    $this->error["msg"] = "Có lỗi khi đăng ký tài khoản";
                }
            } else {
                $this->error["status"] = false;
                $this->error["msg"] = "Mật khẩu tối thiểu 8 ký tự";
            }
        } else {
            $this->error["status"] = false;
            $this->error["msg"] = "Vui lòng không để trống";
        }
    }
}
