<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Create Plan</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

    <!-- check if already logged in -->
    <?php include 'check_permissions.php';?>

    <!-- All js -->
    <!--jQuery Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- js functions -->
    <script type="text/javascript">
        function toggle_attend(plan_id, element) {
            console.log("Toggle Attend");
            var url = 'run_querry/update_invite_status.php',
            data =  {'action': 'toggle_attend', 'id': plan_id};
            $.post(url, data, function (response) {
                //if new value is attended
                console.log(response);
                if (response == 1){
                    new_text = "Attended";
                    new_class = "button-blue";
                }
                else {
                    new_text = "Missed";
                    new_class = "button-white";
                }
                console.log(new_text);
                // change visual appearance of button to confirm change
                element.value = new_text;
                element.className = new_class;
            });
        }

        function toggle_accept(plan_id, element) {
            console.log("Toggle Accept");
            var url = 'run_querry/update_invite_status.php',
            data =  {'action': 'toggle_accept', 'id': plan_id};
            $.post(url, data, function (response) {
                //if new value is accepted
                console.log(response);
                if (response == 1){
                    new_text = "Attending";
                    new_class = "button-blue";
                }
                //is declined
                else {
                    new_text = "Declined";
                    new_class = "button-white";
                }
                console.log(new_text);
                // change visual appearance of button to confirm change
                element.value = new_text;
                element.className = new_class;
            });
        }
    </script>

</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    <!-- main  -->
    <div class="container">
        <h1>Planned Activities</h1>
        <div class="card-grid">
            <!-- get all planned activities invited to after today -->
            <?php
                // Create connection
                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
                // Check connection
                if (!conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT p.id, p.activity_id, DATE_FORMAT(p.date, '%W, %M %D') as date, TIME_FORMAT(p.time, '%h:%i %p') as time, a.name, a.image, i.accepted
                FROM planned_activity p, invitees i, activity a
                WHERE i.user_id = '$user_id'
                AND a.id = p.activity_id
                AND i.plan_id = p.id
                AND date >= CURDATE()";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data
                    while($row = mysqli_fetch_assoc($result)) {
                        // Display html content on page
                        echo "<div class='search-result-card'>
                                <div class='image-cap'>
                                    <figure class='cap'>
                                        <img src='uploads/" . $row['image'] . "' class='cap'>
                                    </figure>
                                    <div class='gradient-bg'>
                                        <h2>" . $row['name'] . "</h2>
                                    </div>
                                </div>
                                <div class='after-cap'>
                                    <p class='date-time'>" . $row['date'] . "</p>
                                    <p class='date-time'>" . $row['time'] . "</p>
                                    <form action='view_plan.php' method='post'>
                                        <input type='hidden' name='plan_id' value='" . $row['id'] . "' id='planned-page'>
                                        <input type='submit' value='View' class='button-grey' id='planned-page'>";

                        //check if they are planning to attend
                        $accept_status = $row['accepted'];
                        if($accept_status == 1){
                            $button_text = "Attending";
                            $button_class = "button-blue";
                        }
                        elseif ($accept_status === null) {
                            $button_text = "Accept";
                            $button_class = "button-yellow";
                        } else {
                            $button_text = "Declined";
                            $button_class = "button-white";
                        }
                        echo "<input type='button' id='accept_button' class='$button_class' value='$button_text' onclick='toggle_accept(" . $row['id'] . ", this)'>
                                </form>
                                </div>
                            </div>";
                    }
                } else {
                    echo "No upcomming activities.";
                }

                //close connection
                mysqli_close($conn);
            ?>
        </div>
        <h1>Past Activities</h1>
        <div class="card-grid">
            <?php
                // Create connection
                $conn = mysqli_connect("db.luddy.indiana.edu", "i494f20_team18", "my+sql=i494f20_team18", "i494f20_team18");
                // Check connection
                if (!conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT p.id, p.activity_id, DATE_FORMAT(p.date, '%W, %M %D') as date, p.time, a.name, a.image, i.accepted, i.attended
                FROM planned_activity p, invitees i, activity a
                WHERE i.user_id = '$user_id'
                AND a.id = p.activity_id
                AND i.plan_id = p.id
                AND date < CURDATE()";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data
                    while($row = mysqli_fetch_assoc($result)) {
                        // Display html content on page

                        echo "<div class='search-result-card'>
                                <div class='image-cap'>
                                    <figure class='cap'>
                                        <img src='uploads/" . $row['image'] . "' class='cap'>
                                    </figure>
                                    <div class='gradient-bg'>
                                        <h2>" . $row['name'] . "</h2>
                                    </div>
                                </div>
                                <div class='after-cap'>
                                    <p class='date-time'>" . $row['date'] . "</p>
                                    <p class='date-time'>" . $row['time'] . "</p>
                                    <form action='view_plan.php' method='post'>
                                        <input type='hidden' name='plan_id' value='" . $row['id'] . "'  id='planned-page'>
                                        <input type='submit' value='View' class='button-grey'  id='planned-page'>";

                        //check if they have attended
                        $accept_status = $row['accepted'];
                        $attend_status = $row['attended'];
                        if ($accept_status == 1){
                            //if the user accepted the invite
                           if($attend_status == 1){
                                $button_text = "Attended";
                                $button_class = "button-blue";
                            }
                            elseif ($attend_status === null) {
                                $button_text = "Confirm";
                                $button_class = "button-yellow";
                            } else {
                                $button_text = "Missed";
                                $button_class = "button-white";
                            }
                            $onclick = "toggle_attend(" . $row['id'] . ", this)";
                        } else {
                            // if the user did not accept the invite
                            $button_text = "Declined";
                            $button_class = "button-grey";
                        }
                        
                        echo "<input type='button' id='attend_button' class='$button_class' value='$button_text' onclick='$onclick'>
                                </form>
                                </div>
                            </div>";
                    }
                } else {
                    echo "Your past activites will show up here";
                }

                //close connection
                mysqli_close($conn);
            ?>
        </div>
    </div>

</body>
</html>