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
        <title>Register</title>
        <link rel="icon" href="css/img/ico.jpg" type="image/gif" sizes="16x16">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
        <link rel="stylesheet" href="css/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            h1,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
            .w3-bar,h1,h2,h3,button {font-family: "Montserrat", sans-serif}
            body {
                background-image: url("css/img/re.jpg");
                background-repeat: no-repeat;
                background-size: cover;
                font-family: sans-serif;
                min-height:100%;
                height:100%;
                background-position:center;
            }
            .w3-bar .w3-button {
                padding: 10px;
            }
            input[type=text], input[type=password],input[type=email],input[type=number]{
                color:black;
                width: 100%;
                padding: 5px 20px;
                display: inline-block;
                border: 1px solid #000;
                border-radius: 6px;
                box-sizing: border-box;
                margin-left:5%;
            }
            select{
                color:black;
                width: 100%;
                padding: 5px 20px;
                display: inline-block;
                border: 1px solid #000;
                border-radius: 6px;
                box-sizing: border-box;
                margin-left:5%;
            }
            input[type=submit]{
                background-color: black;
                color: white;
                font-size:20px;
                padding: 5px 0px;
                margin: 4px 0;
                border: none;
                border-radius: 35px;
                cursor: pointer;
                margin-top:20px;
                margin-left:12%;
            }
            button{
                width: 40%;
                background-color:black;
                color: white;
                font-size:20px;
                padding: 5px 0px;
                margin: 4px 0;
                border: none;
                border-radius: 35px;
                cursor: pointer;
                margin-left:5%;
            }
            option{
                font-size:18;
            }
            input[type=submit]:hover{
                background-color: grey;
            }
            button:hover {
                background-color: grey;
            }
            .ff {
                width: 90%;
                clear: both;
            }
            .center-block {
                top:50%;
                left: 50%;
                transform: translate3d(-50%,-50%, 0);
                position: absolute;
            }
            .ff input {
                width: 100%;
                clear: both;
            }

            .ff input[type=submit] {
                width: 40%;
                clear: both;
            }
        </style>
    </head>
    <body>
        <div class="w3-top">
            <div class="w3-bar w3-white w3-card" id="myNavbar">
                <a href="#" class="w3-bar-item w3-button w3-wide">ACME SPORT ACCESSORIES SHOP</a>
                <a href="login.php" class="w3-bar-item w3-button w3-wide" style="float:right">Log In</a>
            </div>
            <?php
            session_start();
            // put your code here
            /** @var type $_SERVER */
            $Name = $USN = $Password = $Email = $Contact =$Address=$MOP= '';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $Name = $_POST['user_name'];
                $USN = $_POST['user_Id'];
                $Password = $_POST['user_pwd'];
                $Email = $_POST['email_Id'];
                $Contact = $_POST['contact_detail'];
                $Address = $_POST['address'];
                $MOP = $_POST['payment'];

                $res = $db_handle->updateQuery("INSERT INTO `user`(`user_Id`, `user_pwd`, `user_name`, `email_Id`, `contact_detail`, `address`, `payment`) VALUES ('$USN','$Password','$Name','$Email','$Contact','$Address','$MOP')");
                if ($res) {
                    $_SESSION["bres"] = $res;
                    header("Location: login.php");
                } else {
                    echo'<script language="javascript">alert("User Already Exists!")</script>';
                }
            }
            ?>
        </div>
    <center>
        <p class="w3-white" style="font-size:28px;margin-top:5%;width:35%"></p>
    </center>
    <div class="w3-container">
        <div class="w3-row-padding">
            <div class="w3-col l4 m6 w3-margin-bottom">
                <div class="w3-card" style="color:black;background-color:white;border-radius:25px;">
                    <form action="" method="post" >
                        <fieldset>
                            <div class="ff">
                                <div class="center">
                                    <h3>Registration </h3>
                                    </br><input type="text" placeholder="Enter Name" name="user_name" required><br/>
                                    </br><input type="text" placeholder="Enter E-Mail" name="email_Id" required><br/>
                                    </br><input type="text" placeholder="Enter User Name" name="user_Id" id="user_Id" required><br/>
                                    </br><input type="password" placeholder="Password" name="user_pwd" required><br/>
                                    </br><input type="number" placeholder="Enter Contact No" name="contact_detail" required><br/>
                                    </br><input type="text" placeholder="Enter Address" name="address" required><br/>
                                    </br><select placeholder="Enter Payment Type" name="payment" required>
                                        <option value="" disabled="disabled" selected="selected">--Please choose an Payment option--</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                    </select><br/></br>
                                    <button type="button"  name="button" value="Back" onClick= "document.location.href = 'login.php'">Back</button>
                                    <button type="submit" name="submit" value="Register" >Register</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>