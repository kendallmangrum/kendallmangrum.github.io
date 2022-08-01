<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Create Plan</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

    <!-- check if already logged in -->
    <?php include 'check_permissions.php';?>

    <!-- js functions -->
    <script type="text/javascript">
        
        // switch between input options based on what user wants to add
        function openAdd(type){
            if(type == 1){
                // adding users to list
                console.log("Switch to users");
                document.getElementById("add_user").style.display = "block";
                document.getElementById("add_group").style.display = "none";
            }
            else {
                // adding groups
                console.log("Switch to groups");
                document.getElementById("add_group").style.display = "block";
                document.getElementById("add_user").style.display = "none";
            }
        }

        //add users & groups to the invite list & display selections
        function add_invite(type){
            if(type == 1){
                // adding users to list
                console.log("Adding user to list");
                var selection = document.getElementById("pick-friend");
                var display_name = selection.options[selection.selectedIndex].text;
                document.getElementById('invitee-list').insertAdjacentHTML('beforeend', 
                    "<p class='category-blue'><input name='friend[]' value='" + document.getElementById("pick-friend").value + "' type='hidden'>" + display_name + "<p>"
                );
                // hide selection from list
                var display_name = selection.options[selection.selectedIndex].style.display = "none";
            }
            else {
                // adding groups
                console.log("Adding group to list");
                var selection = document.getElementById("pick-group");
                var display_name = selection.options[selection.selectedIndex].text;
                document.getElementById('invitee-list').insertAdjacentHTML('beforeend', 
                    "<p class='category-blue'><input name='group[]' value='" + document.getElementById("pick-group").value + "' type='hidden'>" + display_name + "<p>"
                );
                // hide selection from list
                var display_name = selection.options[selection.selectedIndex].style.display = "none";

            }
        }
    </script>

</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    <!-- main  -->
    <div class="container page-content">
        <h1>Edit Plan</h1>
        <div class="grey-border edit-new-form">
            <?php

                // Create connection
                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
                // Check connection
                if (!conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $plan_id = $_POST['plan_id'];

                $sql = "SELECT a.id, a.name, a.description, p.date, p.time, p.note
                FROM activity a, planned_activity p
                WHERE p.id = $plan_id
                AND p.activity_id = a.id";
                $result = mysqli_query($conn, $sql);

                $row = mysqli_fetch_array($result);
                
                if($row){
                    echo "<h2>" . $row['name'] . "</h2><div class='flex-wrap flex-center'>";

                    $activity_id = $row['id'];
                    
                    // Get categories for activity
                    $cat_sql = "SELECT c.name
                    FROM activity_categories, category c
                    WHERE activity_id = $activity_id
                    AND category_id = c.id";
                    $cat_result = mysqli_query($conn, $cat_sql);
                    if (mysqli_num_rows($cat_result) > 0) {
                        // output data
                        while($cat_row = mysqli_fetch_assoc($cat_result)) {
                            echo "<p class='category'>" . $cat_row['name'] . "</p>";
                        }
                    }

                    echo "</div>
                    <p>" . $row['description'] . "</p>";

                    // Output form to collect user's preferences
                    echo '<form action="run_querry/update_plan.php" method="post">
                        <table>
                            <tr>
                                <td>
                                    <label>Date</label>
                                </td>
                                <td>
                                    <label>Time</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="date" name="date" value="' . $row['date'] . '" required>
                                </td>
                                <td>
                                    <input type="time" name="time" value="' . $row['time'] . '" required>
                                </td>
                            </tr>
                        </table>
                        
                        <div id="add-invites" class="guest-list">
                            <div id="add_user">
                            <label>Invite Users</label>
                                <select id="pick-friend" name="pick-friend" class="invitees">';

                                // get all the users groups to show up
                                $friend_sql = 
                                "SELECT CONCAT(u.first_name,' ',u.last_name) as name, u.google_id
                                FROM user u, is_friends f
                                WHERE (u.google_id = f.user1_id
                                AND f.user2_id = '" . $_SESSION["user_id"] . "'
                                AND f.user1_id NOT IN (SELECT user_id FROM invitees WHERE plan_id = $plan_id))
                                OR (u.google_id = f.user2_id
                                AND f.user1_id = '" . $_SESSION["user_id"] . "'
                                AND f.user2_id NOT IN (SELECT user_id FROM invitees WHERE plan_id = $plan_id))
                                ORDER BY name";

                                $friend_result = mysqli_query($conn, $friend_sql);
                                if (mysqli_num_rows($friend_result) > 0) {
                                    // output data
                                    while($friend_row = mysqli_fetch_assoc($friend_result)) {
                                        echo "<option value='" . $friend_row['google_id'] . "'>" . $friend_row['name'] . "</option>";
                                    } 
                                }

                                echo
                                '</select>
                                <input type="button" value="Add" onclick="add_invite(1)" class="button-blue">
                                <input type="button" value="+ Add Group" onclick="openAdd(2)" class="button-grey">
                            </div>

                            <div id="add_group">
                                <label>Invite Groups</label>
                                <select id="pick-group" name="pick-group" class="invitees">';

                                // get all the users groups to show up
                                $group_sql = "SELECT g.name, g.id
                                FROM friend_group g, is_member m
                                WHERE g.id = m.group_id
                                AND m.user_id = '" . $_SESSION["user_id"] . "'";
                                $group_result = mysqli_query($conn, $group_sql);
                                if (mysqli_num_rows($group_result) > 0) {
                                    // output data
                                    while($group_row = mysqli_fetch_assoc($group_result)) {
                                        echo "<option value='" . $group_row['id'] . "'>" . $group_row['name'] . "</option>";
                                    } 
                                }

                                echo
                                '</select>
                                <input type="button" value="Add" onclick="add_invite(2)" class="button-blue">
                                <input type="button" value="+ Add Participant" onclick="openAdd(1)" class="button-grey">
                            </div>
                        </div>

                        <div id="invitee-list" class="flex-wrap">
                        </div>

                        <label>Note</label>
                        <textarea type="text" name="note" rows="5" maxlength="1000">' . $row['note'] . '</textarea>
                        <br>
                        <input type="hidden" name="plan_id" value="' . $plan_id . '">
                        <a href="history.php"><input type="button" value="Cancel" class="button-grey"></a>
                        <input type="submit" value="Save" class="button-blue">
                    </form>';
                }
                else{
                    echo "Something went wrong";
                }

                //close connection
                mysqli_close($conn);
            ?>
        </div>
    </div>

    <!-- hide one of the divs on page load -->
    <script type="text/javascript">
        window.onload = openAdd(1);
    </script>
</body>
</html>