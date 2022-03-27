<!DOCTYPE html>
<html lang="en">

<head>
    <title>Events page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>

<body>
    <h2>ADD NEW EVENT</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?addr=events" ?>" enctype="multipart/form-data">
        <label>Date</label>
        <input type="text" name="date" placeholder="Example: SEP 2020">
        <label>Location</label>
        <input type="text" name="location" placeholder="Example: Burnaby, BC">
        <label>Short Description</label>
        <input type="text" name="short_description">
        <label>Picture</label>
        <input type="file" name="myfile">
        <button id="mybtn" type="submit">Upload Event</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $date = $_POST['date'];
        $location = $_POST['location'];
        $description = $_POST['short_description'];
        $file = "../evenimg/" . $_FILES['myfile']['name'];
        $picture_tmp = $_FILES['myfile']['tmp_name'];

        $targetdir = '../evenimg/' . basename($_FILES['myfile']['name']);
        $imgdetails = getimagesize($_FILES['myfile']['tmp_name']);

        $connectdb = con_db();
        $eventsquey = "INSERT INTO `events_table`(`event_picture`, `event_date`, `event_location`, 
                `event_description`, `event_picture_tmp`) VALUES ('$file','$date','$location','$description','$picture_tmp')";

        if ($connectdb->query($eventsquey) === TRUE) {
            move_uploaded_file($picture_tmp, $targetdir);
            echo "<p id='success'>Event upload succesfully</p>";
        } else {
            echo "There was an error, please try again later";
        }
        $connectdb->close();
    }
    ?>
    <div>
        <h2>CURRENT EVENTS</h2>
        <table class="table">
            <thead>
                <th scope="col">Picture</th>
                <th scope="col">Date</th>
                <th scope="col">Location</th>
                <th scope="col">Description</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
            </thead>
            <?php
            $connectdb = con_db();
            $selectdb = "SELECT * FROM `events_table`";
            $result = $connectdb->query($selectdb);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td><img width='50px' height='50px' src='" . $row["event_picture"] . "'></td>";
                    echo "<td><p>" . $row['event_date'] . "</p></td>";
                    echo "<td><p>" . $row['event_location'] . "</p></td>";
                    echo "<td><p>" . $row['event_description'] . "</p></td>";
                    $eventid = $row['event_id'];
                    echo "<td><a type='button' href='updateevent.php?updateeventid=" . $eventid . "'>Update</a></td>";
                    echo "<td><a type='button' href='delete.php?deleteeventid=" . $eventid . "'>Delete</a></td>";
                }
            }
            $connectdb->close();
            ?>
        </table>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p id='success'>" . $_SESSION['message'] . "</p>";
            session_unset();
            session_destroy();
        }
        if (isset($_SESSION['messagedeleted'])) {
            echo $_SESSION['messagedeleted'];
            session_unset();
            session_destroy();
        }
        ?>

    </div>

</body>

</html>
<script>
    var inputs = document.getElementsByTagName("input");
    var button = document.getElementById("mybtn");

    function disabled(disabled, bgcolor, cursor, border) {
        button.disabled = disabled;
        button.style.backgroundColor = bgcolor;
        button.style.cursor = cursor;
        button.style.border = border;
    }
    window.addEventListener("load", function() {
        disabled(true, "gray", "default", "none");
    });

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener("change", function(event) {
            if (inputs[0].value == "" || inputs[1].value == "" || inputs[2].value == "" || inputs[3].value == "") {
                disabled(true, "gray", "default", "none");
            } else {
                disabled(false, "green", "pointer", "1px solid black");
            }
        })
    };
</script>