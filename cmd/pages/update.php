<?php
    session_start();
?>
<?php include('./config.php') 
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            body{width: 70%; margin: 10% auto;}
            input{width: 100%; padding: 7px; margin-bottom: 30px; border: 0; border-bottom: 1px solid black;}
            label{font-weight: bold;}
            p{text-align: center; color: red;}
            button[type='submit']{border: 0; cursor: pointer; outline: 0; background-color: green; color: white; border-radius: 10px;padding: 16px 20px;}
        </style>
    </head>
    <body>
        <?php
            $userid = $_GET['updateuserid'];
            $connect = connect();
            $retrievedata = "SELECT * FROM `users_table` WHERE user_id='$userid'";
            $result = $connect->query($retrievedata);
            $email;
            $currentpass;
            $saltcolum;
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                        $email = $row['user_email'];
                        $currentpass = $row['password'];
                        $saltcolum = $row['salt'];
                    }
                }
            $connect->close();
                
        ?>
         <form method="POST" action="<?php echo $_SERVER['PHP_SELF']."?updateuserid=". $userid."&updatepass.php" ?>">
            <label>New email</label>
            <input type="text" name="newemail" value="<?php echo $email?>">
            <label>Previous password</label>
            <input type="password" name="prevpass" value="******">
            <label>New password</label>
            <input type="password" name="newpass" value="******">
            <button type="submit">Submit</button>
        </form>
       
        <?php
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $newemail = $_POST['newemail'];
            $prevpass = $_POST['prevpass'];
            $newpass = md5($_POST['newpass'].$saltcolum);
            function mysleep(){
                $_SESSION['message'] = "Password changed succesfully";
                header("Location:users.php"); 
            }
            if($currentpass == md5($prevpass.$saltcolum)){
                $connect = connect();
                $updatequery = "UPDATE `users_table` SET `user_email`='$newemail',`password`='$newpass' WHERE user_id='$userid'";
                    if($connect->query($updatequery) === TRUE){
                        echo "<p>Info updated succesfully</p>";
                        mysleep();                                           
                    }else{
                        echo "<p>There was a problem, please try again later";
                    }
                    $connect->close();
                    
            }else{
                echo "<p>Previous password is not correct</p>";
            }
            
            
        }
        
        ?>
    </body>
</html>