<?php include('./config.php') ?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
          
        <?php
        if(isset($_GET['deleteeventid'])){
            $getuserid =$_GET['deleteeventid'] ;
            $connectdb = connect();
            $detelequery = "DELETE FROM `events_table` WHERE event_id='$getuserid'";
            if($connectdb->query($detelequery)===TRUE){
                echo "Event deleted";
            }else{
                return false;
            }
            $connectdb->close();
            $_SESSION['messagedeleted'] = "<p>Event deleted succesfully</p>";
            header("Location:events.php");
        }
        else if(isset($_GET['deleteuserid'])){
            $userid = $_GET['deleteuserid'];
            $connectdb = connect();
            $detelequery = "DELETE FROM `users_table` WHERE user_id='$userid'";
                if($connectdb->query($detelequery) === TRUE){
                    echo "<p>User deleted succesfully</p>";
                    
                }else{
                    echo "<p>There was a problem, please try again later";
                }
                $connectdb->close();
            header("Location:users.php");
        }
       
        ?>
    </body>
</html>