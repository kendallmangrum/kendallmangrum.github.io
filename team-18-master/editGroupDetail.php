<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? View Group Detail</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

    <!-- check if already logged in -->
    <!-- js functions -->
</head>
<body>
    <?php include 'load_nav_bar.php'; ?>

    <!-- main  -->
    <a type='button' class='button-grey' href='viewUserGroups.php'>Back to Groups</a>

    <div id="groupContainer" class="container page-content"></div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">

        var userCount = 1;

        var groupID = '4'; // need to get this from....  var formInput1HTML = '<input type="hidden" name="group_id" value="4">'

        $(document).ready(function () {

            //*Start - getGroupMembersData.php AJAX
            $.ajax
                ({
                    type: "POST",
                    url: "updateGroup.php",
                    data: { groupID: groupID },
                    dataType: 'json',
                    cache: false,
                    success: function (data) {

                        var groupContainerHTML = '';
                        var groupUsersHTML = ''

                        var groupNameHTML = '<div class="grey-border"><div class=""><h2 class="lg-cap">Group Name</h2><input>' + data[0].groupName + '</input></div><h2>Group Users</h2>';


                        $.each(data, function (i, groupUsers) {

                            groupUsersHTML += '<div class="flex-wrap"><div class="user"><input>' + groupUsers.userName + '</input></div></div>';

                            userCount++;

                        });

                        var groupDescriptionHTML = '<h2>Description</h2> <input>' + data[0].groupDescription + '</input></div>';

                        groupContainerHTML = groupNameHTML + groupUsersHTML + groupDescriptionHTML;

                        $('#groupContainer').append(groupContainerHTML);
                    }

                }); //* End - getGroupMembersData.php AJAX

        });// End - $( document ).ready(function()

    </script>

     <!-- Save and Cancel buttons -->
                <input type="submit" value="Save" name="save-bttn"> &nbsp; <a href="viewGroupDetail.php"><button>Cancel</button></a>

</body>
</html>