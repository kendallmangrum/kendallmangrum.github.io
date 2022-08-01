<?php

//*** Get User Rows

        $servername = "db.luddy.indiana.edu";
        $dbusername = "i494f20_team18";
        $dbpassword = "my+sql=i494f20_team18";
        $dbname = "i494f20_team18";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT name FROM activity";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {

       //     $fullname = trim($row["last_name"]) . ', ' . trim($row["first_name"]);

            $data[] = array(
                            "activity" => trim($row["name"]),
                            
            );

    }
    
   echo (empty($data) ? null : json_encode($data));exit;

} else {
    
    echo "0 results";
}

mysqli_close($conn);
?>
