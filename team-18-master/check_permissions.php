<?php
    session_start();
    if (!isset($_SESSION['user_id'])){
        //echo "session not set";
        header("Location: login.php");
    }
    else {
        $user_id = $_SESSION["user_id"];
        $username = $_SESSION["username"];
        //echo "session id: $user_id" . !isset($_SESSION['user_id']);
        //echo "username: $username"  . !isset($_SESSION['username']);
    }
?>