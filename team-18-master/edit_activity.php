<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Edit Activity</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

    <!-- check if already logged in -->
    <?php
        include 'check_permissions.php';
        $given_id = $_POST['activity_id'];
    ?>

    <!-- All js -->
    <!--jQuery Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    <!-- main  -->
    <div class="form-large-container page-content">
        <h1>Edit Activity</h1>
        <div class="form-large">
            <!-- get all planned activities invited to after today -->
            <?php
                // Create connection
                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                // GET CURRENT CAT
                $sql = "SELECT category_id FROM activity_categories WHERE activity_id = '$given_id'";
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($result)) {
                    $cat_id = $row['category_id'];
                }
                // create option for that cat to be first
                $sql = "SELECT id, name FROM category";
                $result = mysqli_query($conn, $sql);
                
                $options = "";
                while($row = mysqli_fetch_assoc($result)) {
                    if($row['id'] == $cat_id) {
                        $options .= "<option value='$cat_id'>" . $row['name'] . "</option>
                        <option value=''></option>";
                        $result = mysqli_query($conn, $sql);
                        while ($row2 = mysqli_fetch_assoc($result)) {
                            if($row2['id'] != $cat_id) {
                                $options .= "<option value='" . $row2['id'] . "'>" . $row2['name'] . "</option>";
                            }
                        }
                    }
                }

                $sql = "SELECT id, name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants, image, about_url
                FROM activity
                WHERE id = '$given_id'";
                $result = mysqli_query($conn, $sql);

                $row = mysqli_fetch_array($result);

                if ($row['creator_id' != $user_id]) {

                }
                if($row){
                    echo '<div class="delete-bttn"><form action="run_querry/remove_activity.php" method="POST">
                        <input type="hidden" name="activity_id" value="' . $given_id . '">
                        <input type="submit" value="Delete" class="button-red">
                    </form></div>';
                    echo "<h2 style='width: 100%'>" . $row['name'] . "</h2>";

                    $activity_id = $row['id'];

                    //<!-- Form for user to upload a new profile picture -->
                    //echo '</div>
                    // <br>
                    // <form action="run_querry/update_activity_image.php" method="POST" enctype="multipart/form-data"> 
                    //     <h4>Activity Image</h4>
                    //     <input type="file" name="file" id="file">
                    //     <input type="hidden" name="activity_id" value="' . $activity_id . '">
                    //     <input type="submit" value="upload" name="submit">
                    // </form><br>';

                    // Output form to collect user's preferences
                    echo '<form action="run_querry/update_activity.php" method="POST" enctype="multipart/form-data">
                        <label>Name:</label>
                        <input type="text" name="activity-name" value="' . $row['name'] . '">
                        <label>Description:</label>
                        <textarea type="text" name="description" rows="5" maxlength="1000">' . $row['description'] . '</textarea>
                        <label>Activity Image</label>
                        <input type="file" name="file" id="file">
                        <br><br>
                        <label>Category</label>
                        <select name="cat" id="select" class="form-select">' . $options . '</select>
                        <br>
                        <table>
                            <tr>
                                <td>
                                    <label>Open Time:</label>
                                </td>
                                <td>
                                    <label>Close Time:</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="time" name="open_time" value="' . date('H:i', strtotime($row['open_time'])) . '" required>
                                </td>
                                <td>
                                    <input type="time" name="close_time" value="' . date('H:i', strtotime($row['close_time'])) . '" required>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <label>Address</label>
                            <tr>
                                <td>Street 1: </td>
                                <td>
                                    <input type="text" name="street1" value="' . $row['street1'] . '" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Street 2: </td>
                                <td>
                                    <input type="text" name="street2" value="' . $row['street2'] . '">
                                </td>
                            </tr>
                            <tr>
                                <td>City: </td>
                                <td>
                                    <input type="text" name="city" value="' . $row['city'] . '" required>
                                </td>
                            </tr>
                            <tr>
                                <td>State: </td>
                                <td>
                                    <input type="text" name="state" value="' . $row['state'] . '" maxlength="2" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Zip Code: </td>
                                <td>
                                    <input type="text" name="zip" value="' . $row['zip'] . '" required>
                                </td>
                            </tr>
                        </table>
                        <label>Price</label>
                        <input type="number" name="price" value="' . $row['price'] . '" required>
                        <label>Max Participants</label>
                        <input type="number" name="max_participants" value="' . $row['max_participants'] . '" required>
                        <label>About URL</label>
                        <input class="url-input" type="text" name="about_url" value="' . $row['about_url'] . '">
                        <br>
                        <input type="hidden" name="activity_id" value="' . $activity_id . '">
                        <a href="my_activities.php"><input type="button" value="Cancel" class="button-grey"></a>
                        <input type="submit" value="Save" class="button-blue" onclick="toastAlert()">
                    </form>';
                }
                else {
                    echo 'There is nothing here.';
                }

                //close connection
                mysqli_close($conn);
            ?>
        </div>
    </div>
    <br><br><br>
    <div id="target"></div>
    <div id="toast">Activity has been updated! Redirecting...</div>
    <!-- <div id="toast-del">Activity has been deleted. Redirecting...</div> -->


    <script type="text/javascript">
        function updateActivity() {
            $("form").on("submit", function(event) {
                event.preventDefault();
                var formValues = $(this).serialize();
                console.log(formValues)
                $.post("run_querry/update_activity.php", formValues, function(data){
                    // document.getElementById('target').innerHTML = data;
                    toastAlert();
                    // sleep(3000);
                    setTimeout(() => { window.location.replace("https://cgi.luddy.indiana.edu/~team18/my_activities.php"); }, 3000);
                });
            });
        }
        function toastAlert() {
            let toast = document.getElementById('toast');
                toast.className = 'show';
                setTimeout(function() {toast.className = toast.className.replace('show', ''); }, 3000);
                setTimeout(() => { window.location.replace("https://cgi.luddy.indiana.edu/~team18/my_activities.php"); }, 3000);
        }
        function toastAlertDelete() {
            let toast = document.getElementById('toast-del');
                toast.className = 'show';
                setTimeout(function() {toast.className = toast.className.replace('show', ''); }, 3000);
        }
        function deleteActivity() {
            $("form").on("submit", function(event) {
                event.preventDefault();
                var formValues = $(this).serialize();
                console.log(formValues)
                $.post("run_querry/remove_activity.php", formValues, function(data){
                    // document.getElementById('target').innerHTML = data;
                    toastAlertDelete();
                    document.getElementById('target').innerHTML = data;
                    // sleep(3000);
                    // setTimeout(() => { window.location.replace("https://cgi.luddy.indiana.edu/~team18/my_activities.php"); }, 3000);
                });
            });
        }
    </script>

</body>
</html>