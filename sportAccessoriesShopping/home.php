<?php
session_start();
$val = filter_input(INPUT_GET, 'val');
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $unavailable = $db_handle->updateQuery("UPDATE `equip` SET `availability`='No' WHERE `code`='" . $_GET["code"] . "'");
                $productByCode = $db_handle->runQuery("SELECT * FROM equip WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));
                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            if (isset($productByCode))
                $_SESSION["up"] = $productByCode;
            break;
    }
}
?>
<HTML>
    <HEAD>
        <TITLE>::HOME::</TITLE>
        <link href="style.css" type="text/css" rel="stylesheet" />
        <!--<link rel="stylesheet" type="text/css" href="css/log_in_sup.css">-->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .w3-bar,h1,h1,h2,h3,h4,h5,h6,button {font-family: "Montserrat", sans-serif}

            .center {
                text-align: center;
            }

            .left {
                text-align: left;
            }

            .right {
                text-align: right;
            }

            body {
                font-family: "Montserrat";
                transition: background-color .5s;
            }

            .sidenav {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #111;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 60px;
            }

            .sidenav a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 25px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }

            .sidenav a:hover {
                color: #f1f1f1;
            }

            .sidenav .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }

            #main {
                transition: margin-left .5s;
                padding: 16px;
            }

            @media screen and (max-height: 450px) {
                .sidenav {padding-top: 15px;}
                .sidenav a {font-size: 18px;}
            }

            .upmsg{
                margin:30px auto;
                padding:10px;
                border-radius:5px;
                color:#3c763d;
                background: #dff0d8;
                border:1px solid #3c763d;
                width: 50%;
                text-align: center;
            }
            a:hover {
                text-decoration: none;
            }
        </style>
    </HEAD>
    <BODY>
        <div id="main">
            <div class="w3-white w3-card" id="myNavbar">
                <a>&nbsp;&nbsp;</a>
                <a style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776</a>
                <a href="home.php" class="w3-bar-item w3-button w3-wide">ACME SPORT ACCESSORIES SHOP</a>
                <a href="login.php" class="w3-bar-item w3-button w3-wide" style="float:right">Log Out</a>
                <a href="cart.php" class="w3-bar-item w3-button w3-wide" style="float:right"><img src="https://img.icons8.com/ios-glyphs/64/000000/shopping-cart--v1.png" width="20px" height="20px"/><STRONG>(<?php
                        if (isset($_SESSION["cart_item"])) {
                            echo count($_SESSION["cart_item"]);
                        } else {
                            echo '0';
                        }
                        ?>)</STRONG></a>
                <a style="float: right"><form role="form" id="templatemo-preferences-form" name="registration" action="" method="post">

                        <div class="right">
                            <input type="text" id="Search" class="product-quantity" placeholder="Search Products" name="name">
                            <button type="submit" class="btn btn-primary" name="search" value="Search" ><img src="https://img.icons8.com/fluent-systems-filled/96/ffffff/search-more.png" width="20px" height="20px"/></button><br/>
                        </div>
                    </form></a>
            </div>
            <?php
            $up_msg = "Item Added to Cart Successfully!";
            if (isset($_SESSION['up'])) {
                echo "<div class='upmsg'>" . $up_msg . "</div>";
                unset($_SESSION['up']);
            }
            ?>
            <div class="center">
                <?php
                $username = $_SESSION['username'];
                echo '<html><br><h1>Welcome ' . ucfirst($username) . ' !</h1></html>';
                ?>
            </DIV>

            <?php
            $productName = filter_input(INPUT_POST, 'name');

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            if ($productName . null) {
                if (isset($val))
                    $product_array = $db_handle->runQuery("SELECT * FROM equip WHERE `name` LIKE '%$productName%' AND `availability`= 'YES' AND `cat`=" . $val . " ORDER BY id ASC");
                else
                    $product_array = $db_handle->runQuery("SELECT * FROM equip WHERE `name` LIKE '%$productName%' AND `availability`= 'YES' ORDER BY id ASC");
            } else {
                if (isset($val))
                    $product_array = $db_handle->runQuery("SELECT * FROM equip WHERE `availability`= 'YES' AND `cat`=" . $val . " ORDER BY id ASC");
                else
                    $product_array = $db_handle->runQuery("SELECT * FROM equip WHERE `availability`= 'YES' ORDER BY id ASC");
            }
            ?>

            <div id="product-grid">
                <?php
                $res = str_replace("'", "", $val);
                if (isset($val)) {
                    ?>
                    <div class="txt-heading"><?php echo $res; ?> Products</div>
                    <?php
                } else {
                    ?>
                    <div class="txt-heading">Products</div>
                    <?php
                }

                if (!empty($product_array)) {
                    foreach ($product_array as $key => $value) {
                        ?>
                        <div class="product-item">
                            <form method="post" action="home.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                                <div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>" width="250" height="155"></div>
                                <div class="product-tile-footer">
                                    <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                    <div class="product-price"><STRONG><?php echo "₹ " . $product_array[$key]["price"]; ?></STRONG></div><BR><br>
                                    <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="1" readonly/><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="no-records">No Products Found </div>
                <?php } ?>
            </div>
        </DIV>
        <?php include 'drawer.php'; ?>
    </BODY>
</HTML>