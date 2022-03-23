<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'johnnyandrose';
$dbcon = new mysqli($servername, $username, $password, $database);
if ($dbcon->connect_error) {
    die("Connection Error: " . $dbcon->connect_errno);
}
$sql_cmd = "SELECT * FROM `events_table` ";
$result = $dbcon->query($sql_cmd);
$trtd = '';
while ($row = $result->fetch_assoc()) {
    $trtd .= "<tr><td>" . $row['event_id'] . "</td><td>" . $row['event_picture'] . "</td><td>" . $row['event_date'] . "</td><td>" . $row['event_location'] . "</td><td>" . $row['event_description'] . "</td><td> <a href='" . $_SERVER['PHP_SELF'] . "?addr=events&event_id=" . $row['event_id'] . "'>Edit</a></td></tr>";
}
$disp = 'hidden';
$info = array('event_id' => '', 'event_picture' => '', 'event_date' => '', 'event_location' => '', 'event_description' => '');
if (isset($_GET['event_id'])) {
    $disp = 'visible';
    $sql_cmd = "SELECT * FROM events_table WHERE event_id=" . $_GET['event_id'] . "";
    $result = $dbcon->query($sql_cmd);
    $row = $result->fetch_assoc();
    $info['event_id'] = $row['event_id'];
    $info['event_picture'] = $row['event_picture'];
    $info['event_date'] = $row['event_date'];
    $info['event_location'] = $row['event_location'];
    $info['event_description'] = $row['event_description'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql_cmd = "UPDATE events_table 
        SET event_id='" . $_POST['event_id'] . "',
        event_picture='" . $_POST['event_picture'] . "',
        event_date='" . $_POST['event_date'] . "',
        event_location='" . $_POST['event_location'] . "',
        event_description='" . $_POST['event_description'] . "'
        WHERE event_id=" . $_POST['event_id'] . " ";
    $result = $dbcon->query($sql_cmd);
    if ($result === false) {
        echo "<div class='title' style='color:red;'>Error happened</div>";
    } else {
        echo "<div class='title' style='color:blue;'>Edited</div>";
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
    <div class="title">Events List</div>
    <table>
        <tr>
            <th>ID</th>
            <th>Picture</th>
            <th>Date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Edit</th>
        </tr>
        <?php echo $trtd ?>
    </table>

    <!-------------------- edit form --------------------->
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?addr=events' ?>" method="POST" style="visibility: <?php echo $disp ?>;">
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