<?php session_start() ?>
<?php include('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Update event</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="./styles.css">
        
    </head>
    <body>
        <?php
            function getuserid(){
                $urleventid = $_GET['updateeventid'];
                return $urleventid;
            }
            $connectdb = con_db();
            $selectevent = "SELECT * FROM `events_table` WHERE event_id='".getuserid()."'";
            $result = $connectdb->query($selectevent);
            $newdate;
            $newpicture;
            $newlocation;
            $newdescription;
            $newpicture_tmp;
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()){
                    $newdate = $row['event_date'];
                    $newpicture = $row['event_picture'];
                    $newlocation = $row['event_location'];
                    $newdescription = $row['event_description'];
                    $newpicture_tmp = $row['event_picture_tmp'];
                }
            }
            
            $connectdb->close(); 
            
        ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']."?updateeventid=".getuserid()."&updateevent.php" ?>" enctype="multipart/form-data">
            <label>New Date</label>
            <input type="text" name="newdate" value="<?php echo $newdate ?>">
            <label>New Location</label>
            <input type="text" name="newlocation" value="<?php echo $newlocation?>">
            <label>New Short Description</label>
            <input type="text" name="new_short_description" value="<?php echo $newdescription ?>">
            <label>New Picture</label>
            <img width='100px' height='100px' src="<?php echo $newpicture?>">
            <input type="file" name="new_myfile" >
            <button id="mybtn" type="submit">Upload Event</button>
        </form>
        <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $newfilepictureName = "./evenimg/".$_FILES['new_myfile']['name'];
            $newfilepictureTmpName = $_FILES['new_myfile']['tmp_name'];
            $newdateevent = $_POST['newdate'];
            $newlocationevent = $_POST['newlocation'];
            $newdescriptionevent = $_POST['new_short_description'];;
            if($newfilepictureName == "./evenimg/"){
                $newfilepictureName = $newpicture;
                $newfilepictureTmpName = $newpicture_tmp; 
            }        
            $dbconnect = con_db();
            $sqlupdate = "UPDATE `events_table` SET `event_picture`='$newfilepictureName',
            `event_date`='$newdateevent',`event_location`='$newlocationevent',`event_description`='$newdescriptionevent' 
            WHERE `event_id`='".getuserid()."'";
                if($dbconnect->query($sqlupdate) === TRUE){
                    $targetdir = './evenimg/'.basename($newfilepictureName);
                    pic_upload($newfilepictureTmpName, $targetdir);
                    header("Location:events.php");
                    $_SESSION['message'] = "<p id='sucess'>Event updated Succesfully</p>";
                }else{
                    echo "There was a mistake, please try again later";
                }
            $dbconnect->close();
        }        
        ?>
    </body>
    <script>
    var inputs = document.getElementsByTagName("input");
    var button = document.getElementById("mybtn");
    console.log(inputs);
    button.disabled=true;
    for(var i=0;i<inputs.length;i++){
        inputs[i].addEventListener("blur", function(event){
        if(inputs[0].value == "" || inputs[1].value == ""|| inputs[2].value == ""){
            button.disabled = true;
        }else{
            button.disabled = false;
        }
    })
    }
    

</script>
</html>