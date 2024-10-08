<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $email;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->email = $dbc->email;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->email, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $email, $password)
    {
        $email = $this->prepareData($email);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where email = '" . $email . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbemail = $row['email'];
            $dbpassword = $row['password'];
            if ($dbemail == $email && password_verify($password, $dbpassword)) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table, $first_name, $last_name, $email, $contact_number, $password)
    {
        $first_name = $this->prepareData($first_name);
        $last_name = $this->prepareData($last_name);
        $email = $this->prepareData($email);
        $contact_number = $this->prepareData($contact_number);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (first_name, last_name, email, contact_number, password) VALUES ('" . $first_name . "','" . $last_name . "','" . $email . "','" . $contact_number . "','" . $password . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    function getFirstName($table, $email) 
    {
        $email = $this->prepareData($email);
        $this->sql = "SELECT first_name FROM " . $table . " WHERE email = '" . $email . "'";
        $result = mysqli_query($this->connect, $this->sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['first_name'];
        }
        return null;
    }

}

?>
