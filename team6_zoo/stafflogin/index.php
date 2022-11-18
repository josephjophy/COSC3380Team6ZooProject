
<!DOCTYPE html>
<html lang = "en">
    <head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "index.css">
</head>

<body id = "index">

<div id = "login-menu">Staff Login </div>

<form action = "index.php" method = "post" >
<input type = "text" name = "Username" class = "username" placeholder = "Username" required> <br>
<input type = "password" name = "Password" placeholder = "Password" required>  <br>
<input type = "submit" name = "login" value = "login">
</form>
</body>

<!-- This allows login authentication for different roles -->
<?php
$conn = mysqli_connect('team6awsdb.cethcqcyjpsc.us-east-1.rds.amazonaws.com', 'admin', 'team6database', 'README_RECOVER_DATABASES2');
if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }

  if (isset($_POST['login'])){
    $un = $_POST['Username'];
    $pw = $_POST['Password'];
    $query = "SELECT Zoousername, Userpassword,role FROM README_RECOVER_DATABASES2.USER WHERE Zoousername = '$un' AND Userpassword = '$pw'";
    $user = mysqli_query($conn, $query);
    //this makes sure a unique user exists
    if ($user->num_rows == 1){
            $user_role = $user->fetch_assoc()["role"];
            if ($user_role == 'manager'){
               header('location:../manager/index.php');
            }
            if ($user_role == 'employee'){
               header('location:../employee/index.php');
            }
            exit();
    }
    else{
        echo 'Invalid username or password';
    }
  }

?>

<html>