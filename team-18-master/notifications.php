<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Notifications</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
    <?php include 'check_permissions.php';?>
    <!-- All js -->
    <!--jQuery Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- request all notifications for user on page load -->
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({    //create an ajax request to access_notifications.php
                type: "GET",
                url: "access_notifications.php",             
                dataType: "html",   //expect html to be returned                
                success: function(response){                    
                    document.getElementById("notifications").innerHTML = response;
                }
            });
        });
    </script>

    <!-- js functions -->
    <script type="text/javascript">
    function del_note(note_id) {
        var url = 'access_notifications.php',
        data =  {'action': 'del_notification', 'id': note_id};
        $.post(url, data, function (response) {
            // Response div goes here.
            if(response == "success"){
                //alert("Notification successfully deleted.");
                document.getElementById(note_id).style.display = "none";
            }
            else{
                console.log('Unable to delete notification.');
            }
            //console.log(response);
        });
    }
    //approve notification request
    function approve_req(note_id) {
        var url = 'access_notifications.php',
        data =  {'action': 'approve_request', 'id': note_id};
        $.post(url, data, function (response) {
            //if approval is successful, also delete notification
            if(response == "success"){
                console.log('Request Successful');
                del_note(note_id);
            }
            else{
                console.log('Unable to complete request');
            }
            console.log(response);
        });
    }
    </script>
    
</head>
<body>
    <!-- Navigation -->
    <?php include 'load_nav_bar.php';?>
    
    
    
    <!-- main  -->
    <div class="container">
        <h1>Notifications</h1>
        <div class="notif-cards" id="notifications">
            <!-- built from ajax GET request -->
        </div>
    </div>

</body>
</html>