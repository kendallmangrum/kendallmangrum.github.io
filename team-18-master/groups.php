<!DOCTYPE html>
<html lang="en">
<head>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Create Groups">
        <meta name="author" content="Robby Goldberg">
        <link href="style.css" rel="stylesheet">

        <title>Groups</title>
        <?php include 'check_permissions.php';?>

        

        <style>
            * {
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Roboto', sans-serif;
                color: #000;
                background-color: #fff;
                -webkit-font-smoothing: antialiased;
            }
            /* black fonts*/

            /* ------ Group Styles --------- */
            
            .title-group {
                padding-bottom: 0px;
                color: #000
            }
            .group-container {
                margin-left: auto;
                margin-right: auto;
                max-width: 768px;
            }
            
        </style>
    </head>

    <body>
        <?php include 'load_nav_bar.php';?>
        
        <!--- Group Section---->
        <section class="group-section container page-content">
            <div class="group-container container-fluid ">
            <br>    
            <h1 class="title-group text-center">Create Groups</h1><br>

                <div class="row grey-border edit-new-form">

                    <div class=""></div>

                    <div class="">
                        <form>

                            <div class='form-row'>
                                <div class='form-group'>
                                    <label for='groupName' class='font-weight-bold'>Group Name</label>
                                    <input class='form-control' type='text' id='groupName' value=''></input>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group'>
                                    <label for='userNameSelection' class='font-weight-bold'>Users</label>
                                    <select onchange="getMultipleSelected(this.id)" id="userNameSelection" multiple></select>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group'>
                                    <label for='groupDescription' class='font-weight-bold'>Group Description</label>
                                    <textarea class='form-control' id="groupDescription" type="text" name="note" rows="5" maxlength="1000" placeholder="Write a description for your group."></textarea>
                                </div>
                            </div>

                            <button type='button' class='button-blue' onclick='createGroup()'>Create Group</button>
                        </form>
                    </div>

                    <div class=""></div>

                </div>
                <!-- // End row -->

            </div>
            <!-- // End group-container -->

        </section>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>




        <script>
            var userNameSelect = ''       //** Global variable to store retrieved User IDs and User Names.
            var userNameSelectArray = [];  //** Global array to store userNameSelect data in getUserData.php AJAX

            var arrayOfSelecedIDs = [];     //** Global array to store selected users IDs populated in getMultipleSelected function and used by createGroup.php AJAX


            $(document).ready(function () {



                //Start - getUserSelectionData
                $.ajax
                    ({
                        type: 'POST',
                        url: 'getUserData.php',
                        dataType: 'json',
                        cache: false,
                        success: function (data) {
                            if (data == "" || data == null) {
                                return;
                            } else {
                                $.each(data, function (i, userNames) {

                                    $("#userNameSelection").append('<option value="' + userNames.userID + '">' + userNames.userName + '</option>');

                                });



                            }
                        }//* End - success: function (data)
                    }); //* End - getUserSelectionData


            });// End - $( document ).ready(function()

            //*******************************************************
            //Start - getMultipleSelected
            //******************************************************
            function getMultipleSelected(fieldID) {

                // Reset background color to white if there was a previous error
                $(".custom-select").css("background-color", "#FFF").focus();

                //** Array to store selected users IDs used createGroup.php AJAX
                arrayOfSelecedIDs = [];

                // fieldID is id set on select field
                // get the select element

                var elements = document.getElementById(fieldID).childNodes;

                // loop over option values
                for (i = 0; i < elements.length; i++) {

                    // if option is select then push it to object or array
                    if (elements[i].selected) {
                        //push to array of selected values
                        arrayOfSelecedIDs.push(elements[i].value)
                    }

                }
                // Check the ID array
                console.log(arrayOfSelecedIDs);
            }
            //*******************************************************
            //Start - createGroup
            //******************************************************
            function createGroup() {

                // Check if users select
                if ($('#userNameSelection').val() == '') {

                    alert('Must Select Usernames');

                    $('.custom-select').css('background-color', '#FF4D4D').focus();



                    return;

                }

                if ($('#groupName').val() == '') {

                    alert('Must Select Group Name');

                    $('#groupName').css('background-color', '#FF4D4D').focus();

                    //document.getElementById('groupName').focus();
                    //document.getElementById('groupName').style.backgroundColor='#FF4D4D';

                    return;
                }

                if ($('#groupDescription').val() == '') {

                alert('Create a Group Description');

                $('.custom-select').css('background-color', '#FF4D4D').focus();

                return;

                }

                //Encode your ID array string into JSON.
                var jsonString = JSON.stringify(arrayOfSelecedIDs);

                $.ajax({
                    type: "POST",
                    url: "createGroup.php",
                    data: {
                        groupName: $('#groupName').val(),
                        groupDescription: $('#groupDescription').val(),
                        userIDs: jsonString,
                    },
                    cache: false,

                    success: function (response) {

                        var groupname = $('#groupName').val();

                        alert(groupname + ' has been successfully created');

                        //console.log(response);

                        location.reload();
                    }

                });

            }// End - function createGroup()</script>

    </body>
</html> 