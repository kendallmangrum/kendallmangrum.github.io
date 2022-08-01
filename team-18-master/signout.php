<?php
    session_start();
    //clear session data
    session_destroy();
    header('Location: login.php');
?>