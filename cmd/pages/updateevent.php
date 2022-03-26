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

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]."?addr=updateevent&updateeventid=".$_GET["updateeventid"]?>" enctype="multipart/form-data">
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
echo $newpicture;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        unlink($newpicture);
        $newfilepictureName = "./pages/evenimg/".$_FILES['new_myfile']['name'];
        $newfilepictureTmpName = $_FILES['new_myfile']['tmp_name'];
        $newdateevent = $_POST['newdate'];
        $newlocationevent = $_POST['newlocation'];
        $newdescriptionevent = $_POST['new_short_description'];;
        if($newfilepictureName == "./pages/evenimg/"){
            $newfilepictureName = $newpicture;
            $newfilepictureTmpName = $newpicture_tmp; 
        }
        $dbconnect = con_db();
        $sqlupdate = "UPDATE `events_table` SET `event_picture`='".$newfilepictureName."',
        `event_date`='".$newdateevent."',`event_location`='".$newlocationevent."',`event_description`='".$newdescriptionevent."' 
        WHERE `event_id`='".getuserid()."'";
            if($dbconnect->query($sqlupdate) === TRUE){
                $targetdir = './pages/evenimg/'.basename($newfilepictureName);
                pic_upload($newfilepictureTmpName, $targetdir);
                $_SESSION['message'] = "<p id='sucess'>Event updated Succesfully</p>";
                header("Location:".$_SERVER["PHP_SELF"]."?addr=events");
                exit();
            }else{
                echo "There was a mistake, please try again later";
            }
        $dbconnect->close();
    }       
?>

<script>
    var inputs = document.getElementsByTagName("input");
    var button = document.getElementById("mybtn");
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
