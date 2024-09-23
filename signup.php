<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->signUp("members", $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['contact'], $_POST['password'])) {
            echo "Sign Up Success";
        } else echo "Sign up Failed";
    } else echo "Error: Database connection";
} else echo "All fields are requiredPHP";
?>
