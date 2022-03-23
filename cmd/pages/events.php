<?php
//connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'johnnyandrose';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}

//add new event
$button = "<a id='btn' href='" . $_SERVER['PHP_SELF'] . "?addr=events&new=event'> Add new event </a>";
$disp2 = 'none';
if (isset($_GET['new'])) {
    $disp2 = 'block';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['new'])) {

    $insert_cmd = "INSERT INTO `events_table`(`event_picture`, `event_date`, `event_location`, `event_description`) VALUES ('" . $_POST['event_picture'] . "','". $_POST['event_date'] ."','" . $_POST['event_location'] . "','" . $_POST['event_description'] . "')";
    $result = $dbcon->query($insert_cmd);
    if ($result === false) {
        echo "<script>alert('Error happened');</script>";
    } else {
        echo "<script>alert('Saved');</script>";
    }
}


//edit events
$disp = 'none';
$sql_cmd = "SELECT * FROM `events_table` ";
$result = $dbcon->query($sql_cmd);
$trtd = '';
while ($row = $result->fetch_assoc()) {
    $trtd .= "<tr><td>" . $row['event_id'] . "</td><td>" . $row['event_picture'] . "</td><td>" . $row['event_date'] . "</td><td>" . $row['event_location'] . "</td><td>" . $row['event_description'] . "</td><td> <a href='" . $_SERVER['PHP_SELF'] . "?addr=events&event_id=" . $row['event_id'] . "'>Edit</a></td><td><a href='" . $_SERVER['PHP_SELF'] . "?addr=events&eventid=" . $row['event_id']."'>x</a></td></tr>";
}
if (isset($_GET['eventid'])){
    $del_cmd = "DELETE FROM events_table WHERE event_id = ".$_GET['eventid']." ";
    $result = $dbcon->query($del_cmd);
    if ($result === false) {
        echo "<script>alert('Error happened');</script>";
    } else {
        echo "<script>alert('Deleted');</script>";
    }
}
$info = array('event_id' => '', 'event_picture' => '', 'event_date' => '', 'event_location' => '', 'event_description' => '');
if (isset($_GET['event_id'])) {
    $disp = 'block';
    $sql_cmd = "SELECT * FROM events_table WHERE event_id=" . $_GET['event_id'] . "";
    $result = $dbcon->query($sql_cmd);
    $row = $result->fetch_assoc();
    $info['event_id'] = $row['event_id'];
    $info['event_picture'] = $row['event_picture'];
    $info['event_date'] = $row['event_date'];
    $info['event_location'] = $row['event_location'];
    $info['event_description'] = $row['event_description'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['new'])) {
    $sql_cmd = "UPDATE events_table 
        SET event_id='" . $_POST['event_id'] . "',
        event_picture='" . $_POST['event_picture'] . "',
        event_date='" . $_POST['event_date'] . "',
        event_location='" . $_POST['event_location'] . "',
        event_description='" . $_POST['event_description'] . "'
        WHERE event_id=" . $_POST['event_id'] . " ";
    $result = $dbcon->query($sql_cmd);
    if ($result === false) {
        echo "<script>alert('Error happened');</script>";
    } else {
        echo "<script>alert('Edited');</script>";
    }
    $dbcon->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../indexStyle.css?<?php echo time(); ?>" />
    <title></title>
</head>

<body class="event">
    <!-------------------- events list --------------------->
    <div class="title">Events List <?php echo $button ?></div>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Picture</th>
            <th>Date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php echo $trtd ?>
    </table>

    <!-------------------- new event --------------------->
    

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?addr=events&new=event' ?>" method="POST" style="display: <?php echo $disp2 ?>;">
        <h1>ADD NEW EVENT</h1>
        
        <label>Picture</label> <input type="text" name="event_picture"><br>
        <label>Date</label> <input type="date" name="event_date"><br>
        <label>Location</label> <input type="text" name="event_location"><br>
        <label>Description</label> <input type="text" name="event_description"><br>

        <button type="submit">Register</button>
    </form>

    <!-------------------- edit form --------------------->
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?addr=events' ?>" method="POST" style="display: <?php echo $disp ?>;">
        <h1>EDIT EVENTS</h1>
        <input type="hidden" name="event_id" value="<?= $_GET['event_id'] ?>">

        <label>Picture</label> <input type="text" name="event_picture" value="<?= $info['event_picture'] ?>"><br>
        <label>Date</label> <input type="date" name="event_date" value="<?= $info['event_date'] ?>"><br>
        <label>Location</label> <input type="text" name="event_location" value="<?= $info['event_location'] ?>"><br>
        <label>Description</label> <input type="text" name="event_description" value="<?= $info['event_description'] ?>"><br>

        <button type="submit">Register</button>

    </form>
</body>

</html>