<?php session_start(); ?>
<?php include('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>CMS</title>
        <style>
            h2{text-align: center;}
            input, input:hover{width: 100%; padding: 7px; margin-bottom: 30px; border: 0; border-bottom: 1px solid black;} 
            button[type='submit']{border: 0; outline: 0; background-color: green; color: white; border-radius: 10px;padding: 16px 20px; cursor: pointer;}
            form{margin: 5% 0;}
            table td{padding: 0 50px;}
            table th{border-bottom: 1px solid black;}
            label{font-weight: bold;}
            button[type='button']{border: 0; outline: 0; background-color: orange; color: white; border-radius: 10px;padding: 10px 20px;}
            #succes{text-align: center; color: green;}
            #wrong{text-align: center; color: red;}
            #update {color: orange; text-decoration: none;} #update:hover{text-decoration: underline;}
            #delete {color: red; text-decoration: none;} #delete:hover{text-decoration: underline;}
            
        </style>
    </head>
    <body>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=register.php' ?>">
            <h2>ADD NEW USER</h2>
            <label>Email</label>
            <input type="email" placeholder="Write your email" name="email">
            <label>Password</label>
            <input type="password" placeholder="Write your password" name="pass1">
            <label>Repeat password</label>
            <input type="password" placeholder="Repeat the password" name="pass2">
            <button type="submit" id="mybtn">Register</button>
        </form>
        <?php
            if($_SERVER['REQUEST_METHOD']=="POST"){
                $email = $_POST['email'];
                $password1 = $_POST['pass1'];
                $password2 = $_POST['pass2'];
                if($password1 == $password2){
                    $connect = connect();
                    if($connect -> connect_error){
                        die("Connection failed". $connect->connect_error);
                    }else{
                        $checkemail = "SELECT * FROM `users_table` WHERE user_email='$email'";
                        $result1 = $connect->query($checkemail);
                            if($result1->num_rows>0){
                                echo "<p>Email already exists</p>";
                                header("Location: users.php");
                            }else{
                                $salt = rand();
                                $pass = md5($password1.$salt);
                                $registerquery = "INSERT INTO `users_table`(`user_email`, `salt`, `password`) 
                                VALUES ('$email','$salt','$pass')";
                                    if($connect->query($registerquery) === TRUE){
                                        echo "<p id='succes'>User added succesfully</p>"; 
                                    }else{
                                        echo "<p id='wrong'>There was a problem, please try again later</p>";
                                    }
                                $connect->close();   
                            }
                    }
                }else{
                    echo "<p id='wrong'>Passwords don't match, please try again</p>";                    
                }
            }
        ?>
        <div>
            <h2>CURRENT USERS</h2>
            <table class="table">
                <thead>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </thead>
                    <?php
                        $connect = connect();
                        if($connect -> connect_error){
                            die("Connection failed". $connect->connect_error);
                        }else{
                            $retrievedata = "SELECT `user_email`, `user_id` FROM `users_table`";
                            $result = $connect->query($retrievedata);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td>". $row['user_email'] ."</td>";
                                        echo "<td>*******</td>";
                                        echo "<td><a type='button' href='update.php?updateuserid=". $row['user_id'] ."' id='update'>Update</a></td>";
                                        echo "<td ><a type='button' href='delete.php?deleteuserid=". $row['user_id'] ."' id='delete'>Delete</a></td>";
                                        echo "</tr>";
                                    }
                                    
                                }
                        }
                        $connect->close();
                        
                        
                    ?>
            </table>
            <?php
                if(isset($_SESSION['message'])){
                    echo "<p>Information changed succesfully</p>";
                    session_unset();
                    session_destroy();
                }
            ?>
        </div>
    </body>
    <script>
    var inputs = document.getElementsByTagName("input");
    var button = document.getElementById("mybtn");
    function disabled (disabled,bgcolor,cursor,border){
        button.disabled=disabled;
        button.style.backgroundColor = bgcolor;
        button.style.cursor = cursor;
        button.style.border = border;
    }
    window.addEventListener("load", function(){
        disabled(true,"gray","default","none");
    });
    
    for(var i=0;i<inputs.length;i++){
        inputs[i].addEventListener("change", function(event){
        if(inputs[0].value == "" || inputs[1].value == ""|| inputs[2].value == ""){
            disabled(true,"gray","default","none");
        }else{
            disabled(false,"green","pointer","1px solid black");
        }
    })
    };
    

</script>
</html>