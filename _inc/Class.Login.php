<?php
class Login
{
    public $account;
    public $password;
    public $res;
    public $error = array("status" => false, "msg" => "Something went wrong!");
    public function __construct($account, $password = null)
    {
        $this->account = $account;
        $this->password = $password;
    }
    public function Login()
    {
        global $conn;
        $account = $this->account;
        $password = $this->password;
        if (!empty($account) && !empty($password)) {
            $res = mysqli_query($conn, "SELECT COUNT(*) as count,api_key FROM table_accounts WHERE (username = '$account' OR email = '$account') AND (`password` = '$password')");
            $this->res = $row = mysqli_fetch_assoc($res);
            if ($row["count"]) {
                $this->error["status"] = true;
                $this->error["msg"] = "Đăng nhập thành công!";
                $this->error["api_key"] = $row["api_key"];
            } else {
                $this->error["status"] = false;
                $this->error["msg"] = "Tài khoản hoặc mật khẩu không hợp lệ!";
            }
        } else {
            $this->error["status"] = false;
            $this->error["msg"] = "Vui lòng không để trống";
        }
    }
    public function LoginAsApiKey(){
        global $conn;
        $api_key = $this->account;
        if(!empty($api_key)){
            $res = mysqli_query($conn, "SELECT COUNT(*) as count,table_accounts.* FROM table_accounts WHERE api_key = '$api_key'");
            if(mysqli_num_rows($res)){
                $this->error["status"] = true;
                $this->res = mysqli_fetch_assoc($res);
            }
            else{
                $this->error["status"] = false;
                $this->error["msg"] = "API KEY không hợp lệ!";
            }
        }
        else{
            $this->error["status"] = false;
            $this->error["msg"] = "Vui lòng không để trống";
        }
    }
    public function getRes(){
        return $this->res;
    }
}
