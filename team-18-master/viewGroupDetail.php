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
    <?php include 'check_permissions.php';?>

    <!-- main  -->
    

    <div id="groupContainer" class="container page-content"><a type='button' class='button-grey' href='viewUserGroups.php' >Back to Groups</a></div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">

        var userCount = 1;

       // var groupID = $groupID = $_POST['groupID']; // need to get this from....  var formInput1HTML = '<input type="hidden" name="group_id" value="4">'
        window.groupID = '<?=$_POST['groupID']?>'
        $(document).ready(function () {

            //*Start - getGroupMembersData.php AJAX
            $.ajax
                ({
                    type: "POST",
                    url: "getGroupMembersData.php",
                    data: { groupID: groupID },
                    dataType: 'json',
                    cache: false,
                    success: function (data) {

                        var groupContainerHTML = '';
                        var groupUsersHTML = ''

                        var groupNameHTML = '<div class="grey-border"><h1>Group Name</h1><p>' + data[0].groupName + '</p><h2>Group Users</h2><div class="flex-wrap">';


                        $.each(data, function (i, groupUsers) {

                            groupUsersHTML += '<div class="user"><figure class="med-prof-img"><img src="uploads/' + groupUsers.picture + '" class="round" alt="Profile Picture"></figure><p>' + groupUsers.userName + '</p></div>';

                            userCount++;

                        });

                        var groupDescriptionHTML = '</div><h2>Description</h2> <p>' + data[0].groupDescription + '</p></div>';

                        groupContainerHTML = groupNameHTML + groupUsersHTML + groupDescriptionHTML;

                        $('#groupContainer').append(groupContainerHTML);
                    }

                }); //* End - getGroupMembersData.php AJAX

        });// End - $( document ).ready(function()

    </script>

</body>
</html>
