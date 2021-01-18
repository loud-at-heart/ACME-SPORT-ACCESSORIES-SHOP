<?php
session_start();
unset($_SESSION["order_item"]);
$user_Id = $_SESSION['user_Id'];
require_once("dbcontroller.php");
$db_handle = new DBController();
$orderdet = $db_handle->runQuery("SELECT * FROM `items_bought` WHERE username='" . $user_Id . "'");
//print_r($orderdet);
$addpay=$db_handle->runQuery("SELECT * FROM `user` WHERE user_Id='" . $user_Id . "'");
if (isset($orderdet)) {
    foreach ($orderdet as $items) {
        $productByCode = $db_handle->runQuery("SELECT * FROM equip WHERE code='" . $items["code"] . "'");
        $itemArray = array($items["code"] => array('name' => $productByCode[0]["name"], 'code' => $items["code"], 'quantity' => $items["quantity"],'ETD' => $items["delivery_date"], 'address' => $addpay[0]["address"], 'payment' => $addpay[0]["payment"], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));
        if (!empty($_SESSION["order_item"])) {
            $_SESSION["order_item"] = array_merge($_SESSION["order_item"], $itemArray);
        } else {
            $_SESSION["order_item"] = $itemArray;
        }
    }
}
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "return":
            $available = $db_handle->updateQuery("UPDATE `equip` SET `availability`='Yes' WHERE `code`='" . $_GET["code"] . "'");
            $returned_item = $db_handle->updateQuery("DELETE FROM `items_bought` WHERE `code`='" . $_GET["code"] . "'");
            if (!empty($_SESSION["order_item"])) {
                foreach ($_SESSION["order_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["order_item"][$k]);
                    if (empty($_SESSION["order_item"]))
                        unset($_SESSION["order_item"]);
                }
            }
            $_SESSION["remo"] = $available;
            break;
        case "return_all":
            if (isset($_SESSION["order_item"])) {
                foreach ($_SESSION["order_item"] as $item) {
                    $available = $db_handle->updateQuery("UPDATE `equip` SET `availability`='Yes' WHERE `code`='" . $item["code"] . "'");
                    $returned_item = $db_handle->updateQuery("DELETE FROM `items_bought` WHERE `code`='" . $item["code"] . "'");
                }
                unset($_SESSION["order_item"]);
            }
            if (isset($available))
                $_SESSION["reall"] = $available;
            break;
    }
}
?>
<HTML>
    <HEAD>
        <TITLE>::ORDERS::</TITLE>
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
            .downmsg{
                margin:30px auto;
                padding:10px;
                border-radius:5px;
                color:#8b0000;
                background: #ffcccb;
                border:1px solid #8b0000;
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
            </div>
            <?php
            $dwn_msg = "Item Returned!";
            if (isset($_SESSION['remo'])) {
                echo "<div class='downmsg'>" . $dwn_msg . "</div>";
                unset($_SESSION['remo']);
            }
            ?>
            <?php
            $dwn_msg = "All Items Returned!";
            if (isset($_SESSION['reall'])) {
                echo "<div class='downmsg'>" . $dwn_msg . "</div>";
                unset($_SESSION['reall']);
            }
            ?>
            <div id="shopping-cart">
                <div class="txt-heading">Orders</div>
                <?php if (isset($_SESSION["cart_item"])) {
                    ?>
                    <a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a>
                <?php } ?>
                <?php
                if (isset($_SESSION["order_item"])) {
                    $total_quantity = 0;
                    $total_price = 0;
                    ?>	
                    <table class="tbl-cart" cellpadding="10" cellspacing="2">
                        <tbody>
                            <tr>
                                <th style="text-align:left;">Name</th>
                                <th style="text-align:left;">Code</th>
                                <th style="text-align:right;" width="5%">Quantity</th>
                                <th style="text-align:right;" width="10%">Unit Price</th>
                                <th style="text-align:right;" width="10%">Price</th>
                                <th style="text-align:center;" width="10%">ETD</th>
                                <th style="text-align:center;" width="10%">Address</th>
                                <th style="text-align:center;" width="10%">MOP</th>
                                <th style="text-align:center;" width="10%">Return</th>
                            </tr>	
                            <?php
                            foreach ($_SESSION["order_item"] as $item) {
                                $item_price = $item["quantity"] * $item["price"];
                                ?>
                                <tr>
                                    <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                                    <td><?php echo $item["code"]; ?></td>
                                    <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                                    <td  style="text-align:right;"><?php echo "₹ " . $item["price"]; ?></td>
                                    <td  style="text-align:right;"><?php echo "₹ " . number_format($item_price, 2); ?></td>
                                    <td  style="text-align:right;"><?php echo $item["ETD"]; ?></td>
                                    <td  style="text-align:right;"><?php echo $item["address"]; ?></td>
                                    <td  style="text-align:right;"><?php echo $item["payment"]; ?></td>
                                    <td style="text-align:center;"><a href="orders.php?action=return&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="https://img.icons8.com/material/24/000000/return.png" alt="Remove Item" /></a></td>
                                </tr>
                                <?php
                                $total_quantity += $item["quantity"];
                                $total_price += ($item["price"] * $item["quantity"]);
                            }
                            ?>

                            <tr>
                                <td colspan="2" align="right">Total:</td>
                                <td align="right"><?php echo $total_quantity; ?></td>
                                <td align="right" colspan="2"><strong><?php echo "₹ " . number_format($total_price, 2); ?></strong></td>
                                <td align="right" colspan="4"><a id="btnEmpty" href="orders.php?action=return_all">Return All</a></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>		
                    <?php
                } else {
                    ?>
                    <div class="no-records">Your have no Orders<br><br><a id="btnBrowse" href="home.php">Browse Products</a></div>
                        <?php
                    }
                    ?>
            </div>
        </DIV>
        <?php include 'drawer.php'; ?>
    </BODY>
</HTML>