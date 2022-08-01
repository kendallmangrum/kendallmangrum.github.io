<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? View Groups</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <?php include 'load_nav_bar.php'; ?>
    <?php include 'check_permissions.php';?>

    <!-- main  -->
    <div class="container page-content">
        <h1>Your Groups</h1>

        <div id="groupSection" class="card-grid"></div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">

        var groupCount = 1;

        // var userID =  $_SESSION['user_id']; // need to get this from a sesssion variable after log in

        $(document).ready(function () {

            //*Start - getUserGroups.php AJAX
            $.ajax
                ({
                    type: "GET",
                    url: "getUserGroupData.php",
                    dataType: 'json',
                    cache: false,
                    success: function (data) {

                        var groupSectionHTML = '';

                        $.each(data, function (i, groups) {

                            var groupNameHTML = '<h2>' + groups.name + '</h2><br>';

                            var formActionHTML = '<form action="viewGroupDetail.php" method="post">';

                            var formInput1HTML = '<input type="hidden" name="group_id" value="' + groups.groupID + '">';

                            var formInputSubmitHTML = '<input type="submit" value="View" class="button-grey">';

                            var formInputButtonHTML = '<input type="button" id="accept_button" class="button-blue" value="Edit" onclick="toggle_accept(' + groups.groupID + ', this)">';

                            groupSectionHTML += '<div class="group-card grey-border">' + groupNameHTML + formActionHTML + formInput1HTML + formInputSubmitHTML + formInputButtonHTML + '</form></div>';

                            groupCount++;
                        });

                        $('#groupSection').append(groupSectionHTML);
                    }

                }); //* End - getUserGroups.php AJAX

        });// End - $( document ).ready(function()

    </script>

</body>
</html>