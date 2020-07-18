<?php
  include_once 'DBConnector.php';
  include_once 'User.php';
  include_once 'FileUploader.php';
  $con = new DBConnector;

  if (isset($_POST['btn-save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $utc_timestamp = $_POST['utc_timestamp'];
    $offset = $_POST['time_zone_offset'];
    $user = new User($first_name, $last_name, $city, $username, $password, $utc_timestamp, $offset);
    if (!$user->validateForm()) {
        $user->createFormErrorSessions();
        header("Refresh:0");
        die();
    } elseif ($user->isUserExist($con->conn)) {
        session_start();
        $_SESSION['username'] = "Username taken.";
        header("Refresh: 0");
        die();
    }

    $uploader = new FileUploader();
    $uploader->uploadFile();
    $target_file = $uploader->target_file;
    $res = $user->save($con->conn, $target_file);

    if ($res) {
      echo "Save operation successful!";
      if ($uploader->isUploadOk()){
          echo "Image uploaded";
      } else {
          echo "Not uploaded";
      }
    } else {
      echo "An error occurred!";
    }
  }
?>
<html>
  <head>
    <title>New User</title>
    <script type="text/javascript" src="validate.js"></script>
    <link rel="stylesheet" type="text/css" href="validate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script type="text/javascript" src="timezone.js"></script>
  </head>
  <body>
    <form name="user_details" id="user_details" enctype="multipart/form-data" method="post" action=<?=$_SERVER['PHP_SELF'] ?> onsubmit="return validateForm()">
        <table align="center">
            <tr>
                <div id="form-errors">
                    <?php
                        session_start();
                        if (!empty($_SESSION['form-errors'])) {
                            echo $_SESSION["form-errors"];
                            unset($_SESSION['form-errors']);
                        }

                        if (!empty($_SESSION['username'])) {
                            echo $_SESSION['username'];
                            unset($_SESSION['username']);
                        }
                    ?>
                </div>
            </tr>
            <tr>
                <td><input type="text" name="first_name" placeholder="First Name" required/></td>
            </tr>
            <tr>
                <td><input type="text" name="last_name" placeholder="Last Name" /></td>
            </tr>
            <tr>
                <td><input type="text" name="city_name" placeholder="City" /></td>
            </tr>
            <tr>
                <td><input type="text" name="username" placeholder="Username"></td>
            </tr>
            <tr>
                <td><input type="password" name="password" placeholder="Password"></td>
            </tr>
            <tr>
                <td>Profile Image: <input type="file" name="fileToUpload" id="fileToUpload"></td>
            </tr>
            <tr>
                <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
            <input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""/>
            <input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""/>
            <tr>
                <td><a href="login.php">Log In</a> </td>
            </tr>
    </table>
    </form>
  </body>
      <a href="all-records.php">Show All Records</a>


</html>
