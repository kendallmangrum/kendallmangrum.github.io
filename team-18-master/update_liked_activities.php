<?php

    $servername = "db.luddy.indiana.edu";
    $dbusername = "i494f20_team18";
    $dbpassword = "my+sql=i494f20_team18";
    $dbname = "i494f20_team18";

    // Create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if (!conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //session_start();
    // TODO: fix with permissions
    // $_SESSION["user_id"] = '100233765235755679450';
    // $user_id = $_SESSION["user_id"];
    //$user_id = '100233765235755679450';
    include 'check_permissions.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST['action']) {
            case 'add_liked':
                addToLiked($_POST['id']);
                break;
            case 'remove_liked':
                removeFromLiked($_POST['id']);
                break;
        }
    }

    // close connection
    mysqli_close($conn);


    // functions

    // function to add activity to user's liked activities
    function addToLiked($act_id) {
        $col1 = 'user_id';
        $col2 = 'activity_id';
        global $conn;
        global $user_id;
        $sql = "INSERT INTO likes ($col1, $col2) VALUES($user_id, $act_id)";
        mysqli_query($conn, $sql);
        // if (mysqli_query($conn, $sql)) {
        //     echo "success";
        // }
    }



    // function to remove activity from user's liked activities
    function removeFromLiked($act_id) {
        $col1 = 'user_id';
        $col2 = 'activity_id';
        global $conn;
        global $user_id;
        $sql = "DELETE FROM likes WHERE $col1 = $user_id AND $col2 = $act_id";
        mysqli_query($conn, $sql);
    }
?>