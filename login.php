<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['email']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->logIn("members", $_POST['email'], $_POST['password'])) {
            $first_name = $db->getFirstName("members", $_POST['email']); 
            echo "Login Success," . $first_name;
        } else echo "Email or Password wrong";
    } else echo "Error: Database connection";
} else echo "All fields are required";
?>
