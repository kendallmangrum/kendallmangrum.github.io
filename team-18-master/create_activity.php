<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Now? Create Activity</title>

    <!-- Styling and Fonts -->
    <link href="style.css" rel="stylesheet">

    <!-- check if already logged in -->
    <?php include 'check_permissions.php';?>

    <!-- Create a list of categories as HTML elements -->
    <?php 
    //GENERATE CATEGORIES
    session_start();
    $servername = "db.luddy.indiana.edu";
    $dbusername = "i494f20_team18";
    $dbpassword = "my+sql=i494f20_team18";
    $dbname = "i494f20_team18";
    //Create connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
    //Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, name FROM category";
    $result = mysqli_query($conn, $sql);

    $options = "";
    while($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
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
        <h1>Create Activity</h1>
        <div class="form-large">
            <!-- ============== IMAGE FORM ============== -->
            <!-- <form action="run_querry/update_activity_image.php" method="POST" enctype="multipart/form-data"> 
                <label>Upload Activity Image</label>
                <input type="file" name="file" id="file">
                <input type="submit" value="upload" name="submit" onclick="toastAlertImage()">
            </form> -->

            <!-- ============== DATA FORM ============== -->
            <form action="run_querry/create_activity_initial.php" method="post" enctype="multipart/form-data" style="width: 100%">
                <label>Name:</label>
                <input type="text" name="activity-name" placeholder="Be short and concise please!">
                <label>Description:</label>
                <textarea type="text" name="description" rows="5" maxlength="1000"></textarea>
                <br><br>
                <label>Upload Activity Image</label>
                <input type="file" name="file" id="file">
                <br><br>
                <label>Category</label>
                    <select name="cat" id="select">
                        <option value=""></option>
                        <?php echo $options ?>
                    </select>
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
                            <input type="time" name="open_time" required>
                        </td>
                        <td>
                            <input type="time" name="close_time"  required>
                        </td>
                    </tr>
                </table>
                <table>
                    <label>Address</label>
                    <tr>
                        <td>Street 1: </td>
                        <td>
                            <input type="text" name="street1" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Street 2: </td>
                        <td>
                            <input type="text" name="street2">
                        </td>
                    </tr>
                    <tr>
                        <td>City: </td>
                        <td>
                            <input type="text" name="city" required>
                        </td>
                    </tr>
                    <tr>
                        <td>State: </td>
                        <td>
                            <input type="text" name="state" maxlength="2" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Zip Code: </td>
                        <td>
                            <input type="number" name="zip" min="10000" max="99999" required>
                        </td>
                    </tr>
                </table>
                <label>Price</label>
                <input type="number" name="price" placeholder="Scale of 0-5" min="0" max="5"required>
                <label>Max Participants</label>
                <input type="number" name="max_participants" placeholder="Use 0 if no cap." min="0" max="25" required>
                <label>About URL</label>
                <input class="url-input" type="text" name="about_url" placeholder="Not required but recommended.">
                <br>
                <a href="index.php"><input type="button" value="Cancel" class="button-grey"></a>
                <input type="submit" value="Save" class="button-blue">
            </form>
        </div>
    </div>

    <div id="toast">Activity has been created! Redirecting...</div>

    <!-- Toast display -->
    <script type="text/javascript">
        function toastAlert() {
            let toast = document.getElementById('toast');
                toast.className = 'show';
                setTimeout(function() {toast.className = toast.className.replace('show', ''); }, 3000);
                // setTimeout(() => { window.location.replace("https://cgi.luddy.indiana.edu/~team18/my_activities.php"); }, 3000);
        }
        function toastAlertImage() {
            let toast = document.getElementById('itoast');
                toast.className = 'show';
                setTimeout(function() {toast.className = toast.className.replace('show', ''); }, 3000);
        }
    </script>

</body>
</html>