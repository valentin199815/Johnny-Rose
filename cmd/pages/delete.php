<?php
    if(isset($_GET['deleteeventid'])){
        $getuserid =$_GET['deleteeventid'] ;
        $connectdb = con_db();

        $selectquery = "SELECT event_picture FROM `events_table` WHERE event_id='".$getuserid."'";
        $result=$connectdb->query($selectquery);
        if($result->num_rows>0){
            while($row=$result->fetch_array()){
                unlink($row["event_picture"]);
            };
        }

        $detelequery = "DELETE FROM `events_table` WHERE event_id='".$getuserid."'";
        $connectdb->query($detelequery);
        $connectdb->close();
        $_SESSION['message'] = "<p>Event deleted succesfully</p>";
        header("Location:".$_SERVER["PHP_SELF"]."?addr=events");
        exit();
    }
    else if(isset($_GET['deleteuserid'])){
        $userid = $_GET['deleteuserid'];
        $connectdb = con_db();
        $detelequery = "DELETE FROM `users_table` WHERE user_id='".$userid."'";  
        $connectdb->query($detelequery);
        $connectdb->close();
        $_SESSION['message'] = "<p>User deleted succesfully</p>";
        header("Location:".$_SERVER["PHP_SELF"]."?addr=users");
        exit();
    }
?>
