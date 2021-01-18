<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
            .w3-bar,h1,button {font-family: "Montserrat", sans-serif}
            body{
                background: url("https://images.pexels.com/photos/209977/pexels-photo-209977.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
                background-size: cover;
                background-position: center;
                font-family: sans-serif;
                background-repeat: no-repeat;
                height:100%;
                min-height:100%;
            }
            html
            {
                height:100%;
            }
            .w3-bar .w3-button {
                padding: 10px;
            }
        </style>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/log_in_sup.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="w3-top">
            <div class="w3-bar w3-white w3-card" id="myNavbar">
                <a href="#" class="w3-bar-item w3-button w3-wide">ACME SPORT ACCESSORIES SHOP</a>
                </a>
            </div>
        </div>
    <center>
        <br></center>
    <!-- Page for Big screen -->
    <div class="loginbox w3-hide-small">
        <img src="css/img/user.png" class="avatar">
        <h1>Log In</h1>
        <?php
        session_start();
        ?>
        <?php
        if (isset($_SESSION['bres'])) {
            session_destroy();
            echo'<script language="javascript">alert("You are successfully registered. Login to enjoy the services.!")</script>';
        }
        if(isset($_SESSION['lres'])){
            echo'<script language="javascript">alert("You have successfully Logged out !")</script>';
        }
        ?>
        <?php
        // put your code here
        $name = $password = '';
        if (isset($_POST['user_name'])) {
            $name = $_POST['user_name'];

            $password = $_POST['user_pwd'];


//            $con = mysqli_connect("localhost", "root", "", "asa");
//
//            if (mysqli_connect_errno()) {
//                echo "Failed to connect to MySQL: " . mysqli_connect_error();
//            }


            $result = $db_handle->updateQuery("SELECT * FROM `user` WHERE `user_Id` = '$name' AND `user_pwd`='$password'");
            $row = mysqli_fetch_assoc($result);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    session_start();
                    $_SESSION['username'] = $row['user_name'];
                    $_SESSION['user_Id'] = $row['user_Id'];
                    header("Location: home.php");
                } else {
                    echo '<script language="javascript"> alert("Wrong Email or Password") </script>';
                }
            } else {
                echo '<script language="javascript"> alert("Wrong Email or Password") </script>';
            }
        } else {
            
        }
        ?>

        <form role="form" name="registration" action="" method="post">
            <div class="center">
                <label>NAME</label><br/>

                <input type="text" id="lastName" placeholder="Enter Name" name="user_name" required> <br/>

                <label>PASSWORD</label><br/>

                <input type="password" id="lastName4" placeholder="Enter Password" name="user_pwd" required><br/>
                <br/>
                <input type=submit name="logbutton" value="Login"/><br>
                <a href="index.php">Don't have an Account?</a>
            </div>
        </form>
    </div>
</body>

</html>
