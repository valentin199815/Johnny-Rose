<?php
session_start();
//default page
if (!isset($_SESSION['userid'])) {
    header("Location: ./login.php");
    exit();
}
if (!isset($_GET['addr'])) {
    $_GET['addr'] = 'admin_main';
}
if (isset($_GET['signout'])) {
    session_unset();
    session_destroy();
    header("Location: ./login.php?err=loggedout");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./indexStyle.css?<?php echo time(); ?>" />
    <title>Admin page</title>
</head>


<body>
    <div class="top_nav">
        <div class="index_title">Johnny and the <span>Rose</span></div>
        <a class="link" href="<?php echo $_SERVER['PHP_SELF'] . '?signout=1' ?>">Sign out</a>
    </div>

    <div class="main">
        <div class="left_menu">
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=bio' ?>">
                Bio info
                <span></span>
            </a>
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=gallery' ?>">
                Gallery
            </a>
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=events' ?>">
                Events
            </a>
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?addr=users' ?>">
                Users
            </a>
        </div>
        <div class="right">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
                include('./pages/' . $_GET['addr'] . '.php');
            }
            ?>
        </div>
    </div>
</body>

</html>