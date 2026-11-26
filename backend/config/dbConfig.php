<?php
require_once __DIR__ . '/env.php';

class DBController {
    private $host;
    private $user;
    private $password;
    private $database;
    private $from_email;
    private $notification_email;
    private $conn;

    function __construct() {
        // All connection details come from the .env file (see .env.example)
        $this->host = env('DB_HOST', 'localhost');
        $this->user = env('DB_USER', 'root');
        $this->password = env('DB_PASSWORD', '');
        $this->database = env('DB_NAME', 'toilet_conference');
        $this->from_email = env('MAIL_FROM_ADDRESS', '');
        $this->notification_email = env('MAIL_NOTIFY_ADDRESS', '');

        $this->conn = $this->connectDB();
    }

    function connectDB() {
        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $conn;
    }

    function checkValue($value) {
        $value=mysqli_real_escape_string($this->conn, $value);
        return $value;
    }

    function runQuery($query) {
        $result = mysqli_query($this->conn,$query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset))
            return $resultset;
    }

    function insertQuery($query) {
        $result = mysqli_query($this->conn,$query);
        return $result;
    }

    function from_email(){
        return $this->from_email;
    }

    function numRows($query) {
        $result  = mysqli_query($this->conn,$query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    function notify_email(){
        return $this->notification_email;
    }
}
