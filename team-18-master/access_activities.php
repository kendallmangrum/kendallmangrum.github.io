<?php

$conn=mysqli_connect('db.luddy.indiana.edu','i494f20_team18', 'my+sql=i494f20_team18', 'i494f20_team18');

//attempt to connect
if (mysqli_connect_errno()){
    echo 'Failed to connect to MySQL: ' .mysqli_connect_error();
}


include 'check_permissions.php';

//check to see what is being requested
//GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //get all the user's notifications
    // echo "<p>Get Recieved.</p>";
    $sql = "SELECT id, name, image, description FROM activity";

    //run query
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data
        while($row = mysqli_fetch_assoc($result)) {
            $activity_card = "<div class='activity-card' id='" . $row['id']. "' onclick='show_activity(". $row['id'] .")'>
                <h2>" . $row['name'] . "</h2>
                <figure>
                    <img class='activity-thumb' src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "'>
                </figure>
                <p class='activity-desc'>" . $row['description'] . "</p>
            </div>";
            
            echo $activity_card;
        }
    }
    //if there are no results display message.
    else {
        echo "<div class='activity-card'><p>No Activities!</p></div>";
    }
}

//POST request
//takes in any changes that need to be made
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($_POST['action']) {
        case 'view_activity':
            echo get_activity($_POST['id']);
            break;
    }
}

//close connection
mysqli_close($conn);

//functions
//look up info from a specific activity
function get_activity($activity_id){
    global $conn;
    $sql = "SELECT id, name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants, image, about_url FROM activity WHERE id = " . $activity_id;
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {
        $activity_data = "<div class='info-card'>
                <h2>" . $row['name'] . "</h2>
                <img class='activity-thumb' src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "'>";

                // Get categories for activity
                $cat_sql = "SELECT c.name
                FROM activity_categories, category c
                WHERE activity_id = $activity_id
                AND category_id = c.id";
                $cat_result = mysqli_query($conn, $cat_sql);
                if (mysqli_num_rows($cat_result) > 0) {
                    // output data
                    $activity_data .= "<div class='flex-wrap flex-center'>";
                    while($cat_row = mysqli_fetch_assoc($cat_result)) {
                        $activity_data .= "<p class='category'>" . $cat_row['name'] . "</p>";
                    }
                    $activity_data .= "</div>";
                }


                $activity_data .= "<p>" . $row['description'] . "</p>
                <table>
                    <tr>
                        <td>Opening:</td>
                        <td>" . date('h:i a', strtotime($row['open_time'])) . "</td>
                    </tr>
                    <tr>
                        <td>Closing:</td>
                        <td>" . date('h:i a', strtotime($row['close_time'])) . "</td>
                    </tr>
                </table>
                <p>Address: " . $row['street1'] . " " . $row['street2'] . " " . $row['city'] . " " . $row['state'] . " " . $row['zip'] . "</p>
                <p>Max Participants: " . $row['max_participants'] . "</p>
                <a href='" . $row['about_url'] . "' target='_blank'>Find out more here</a>
                <form action='create_plan.php' method='post'>
                    <input type='hidden' name='activity_id' value='" . $row['id'] . "'>
                    <input type='submit' value='Plan' class='button-blue full-button'>
                </form>
            </div>";
    }
    
    return $activity_data;
}
?>