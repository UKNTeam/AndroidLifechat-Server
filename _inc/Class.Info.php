<?php
class Info
{
    public $account;
    public $res;
    public $error = array("status" => false, "msg" => "Something went wrong!");
    public function __construct($account)
    {
        global $conn;
        $this->account = $account;
    }
    public function getData(){
        $account = $this->account;
        global $conn;
        $res = mysqli_query($conn, "SELECT COUNT(*) as count,table_accounts.* FROM table_accounts WHERE (username = '$account' OR email = '$account' OR id = '$account') LIMIT 1");
        return mysqli_fetch_assoc($res);
    }
}
