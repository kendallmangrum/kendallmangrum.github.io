<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Activities</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

    <!-- All js -->
    <!--jQuery Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- request all activities for user on page load -->
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({    //create an ajax request to access_activities.php
                type: "GET",
                url: "access_activities.php",             
                dataType: "html",   //expect html to be returned                
                success: function(response){                    
                    document.getElementById("activities").innerHTML = response;
                }
            });
        });
    </script>

</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    <?php include 'check_permissions.php';?>
    <!-- Cover Card for Activity Viewing -->
    <div id="cover-card-container">
        <div id="cover-card">
            <div id='exit'>X</div>
            <div id='activity-data'></div>
        </div>
    </div>

    <!-- main  -->
    <div class="activity-cards" id="activities">
        <!-- built from ajax GET request -->
    </div>
    
    


<!-- js functions -->
<script type="text/javascript">
    document.getElementById("exit").addEventListener("click", exit_cover);

    function exit_cover() {
        document.getElementById("cover-card-container").style.visibility = "hidden";
        document.getElementById("activity-data").innerHTML = "";
        document.getElementsByTagName("BODY")[0].style.overflow = "auto";
    }

    function show_activity(activity_id) {
        var url = 'access_activities.php',
        data =  {'action': 'view_activity', 'id': activity_id};
        $.post(url, data, function (response) {
            // Response div goes here.
            if(response != ""){
                // alert("Totally worked!");
                document.getElementById("cover-card-container").style.visibility = "visible";
                // document.getElementById("cover-card-container").style.position = "fixed";
                document.getElementById("activity-data").innerHTML = response;
                document.getElementsByTagName("BODY")[0].style.overflow = "hidden";
            }
            else{
                console.log('Unable to view activity.');
            }
            // console.log(response);
        });
    }
    //approve notification request
    // function approve_req(note_id) {
    //     var url = 'access_notifications.php',
    //     data =  {'action': 'approve_request', 'id': note_id};
    //     $.post(url, data, function (response) {
    //         //if approval is successful, also delete notification
    //         if(response == "success"){
    //             console.log('Request Successful');
    //             del_note(note_id);
    //         }
    //         else{
    //             console.log('Unable to complete request');
    //         }
    //         console.log(response);
    //     });
    // }
    </script>

</body>
</html>