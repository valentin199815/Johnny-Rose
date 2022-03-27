<div class="users"> 
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?addr=users' ?>">
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
                $connect = con_db();
                if($connect -> connect_error){
                    die("Connection failed". $connect->connect_error);
                }
                else{
                    $checkemail = "SELECT * FROM `users_table` WHERE user_email='$email'";
                    $result1 = $connect->query($checkemail);
                    if($result1->num_rows>0){
                        echo "<p style='color:red; text-align:center;margin-bottom:20px;'>Email already exists</p>";
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
                    $connect = con_db();
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
                                echo "<td><a type='button' href='".$_SERVER["PHP_SELF"]."?addr=updateuser&updateuserid=". $row['user_id'] ."' id='update'>Update</a></td>";
                                echo "<td ><a type='button' href='".$_SERVER["PHP_SELF"]."?addr=delete&deleteuserid=". $row['user_id'] ."' id='delete'>Delete</a></td>";
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
            }
        ?>
    </div>
</div>
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
            console.log("change");
            if(inputs[0].value == "" || inputs[1].value == ""|| inputs[2].value == ""){
                disabled(true,"gray","default","none");
            }else{
                disabled(false,"green","pointer","1px solid black");
            }
        })
    };
</script>
