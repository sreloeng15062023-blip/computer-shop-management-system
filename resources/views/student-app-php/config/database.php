<?php
    $server_db = "localhost";
    $user_db = "root";
    $password_db = "";
    $db_name = "student_db_kravanh";
    $con = new PDO("mysql:host=$server_db;dbname=$db_name", $user_db, $password_db);
?>