<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }
</script>
<style>
    .dropdown-content {
        display: none;
        background-color: #f1f1f1;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        font-size: 15px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {background-color: #ddd;}

    .dropdown:hover .dropdown-content {display: block;}

    .dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>
<?php
$res = $db_handle->runQuery("select `cat` as category from equip group by `cat`");
?>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="home.php"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/home.png" width="30px" height="30px"/>  Home</a>
    <div class="dropdown">
        <a href="#"><img src="https://img.icons8.com/ios-glyphs/30/ffffff/opened-folder.png"/>  Categories</a>
        <div class="dropdown-content">
            <?php
            foreach ($res as $item) {
                $val = $item['category'];
                $img = getIcon($val);
                ?>
                <div class="action">
                    <a href="home.php?val='<?php echo $item['category']; ?>'"><img src="<?php echo $img; ?>"/> <?php echo $item['category']; ?></a>
                </div>
<?php } ?>
        </div>
    </div>
    <a href="orders.php"><img src="https://img.icons8.com/material-rounded/48/ffffff/shopping-bag.png" width="30px" height="30px"/>  Orders</a>
    <!--    <a href="booklist.php">Book List</a>
        <a href="#">Add Books</a>-->
</div>

<?php
function getIcon($img) {
    switch ($img) {
        case "Baseball":
            return 'product-images/cat_icons/baseball.png';
            break;
        case "Basketball":
            return 'product-images/cat_icons/basketball.png';
            break;
        case "Cricket":
            return 'product-images/cat_icons/cricketball.png';
            break;
        case "Hockey":
            return 'product-images/cat_icons/hockeystick.png';
        case "Tennis":
            return 'product-images/cat_icons/tennisracket.png';
            break;
        case "Volleyball":
            return 'product-images/cat_icons/volleyball.png';
            break;
        case "Weightlifting":
            return 'product-images/cat_icons/dumbbell.png';
            break;
        default:
            return 'product-images/cat_icons/sport.png';
            break;
    }
} // call the function
?>