<?php
include "./pages/config.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
    <title>CMD LOGIN</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="loginform">
        <p>LOGIN</p>
        <div class="inputRow">
            <label for="user"> Email </label>
            <input type="text" name="user_email" id="email" placeholder="Enter email address" required />
        </div>
        <div class="inputRow">
            <label for="pass"> Password </label>
            <div class="passwordLine">
                <input type="password" name="password" id="pass" placeholder="Enter password" required />
                <i class="fas fa-eye" id="togglepass"></i>
            </div>
        </div>
        <div class="btnRow">
            <button type="submit">Login</button>
            <button type="reset">Reset</button>
        </div>
    </form>
    <script>
        document.querySelector('#togglepass').addEventListener('click', function(e) {
            // toggle the type attribute
            const type = document.querySelector('#pass').getAttribute('type') === 'password' ? 'text' : 'password';
            document.querySelector('#pass').setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $loginuser = $_POST['user_email'];
        $loginpassword = $_POST['password'];
        $dbcon = con_db();
        if ($dbcon->connect_error) {
            die("Connection Error: " . $dbcon->connect_errno);
        }
        //check the email(username)
        $select_cmd = "SELECT salt FROM `users_table` WHERE user_email='" . $loginuser . "'";
        $result = $dbcon->query($select_cmd);
        //check the password
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
             $salt = $row['salt'];
            }
            $tmppass = md5($loginpassword . $salt);
            $select_cmd = "SELECT * FROM `users_table` WHERE user_email='" . $loginuser . "' AND password='" . $tmppass . "'";

            //$select_cmd = "SELECT * FROM `users_table` WHERE user_email='" . $loginuser . "' AND password='" . $loginpassword . "'";

            $result = $dbcon->query($select_cmd);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['userid'] = $row['user_id'];
                    header("Location: ./index.php");
                    exit();
                }
            } else {
                echo "<h2 style='color:blue; margin-top:1rem'>Wrong user e-mail / password</h2>";
            }
        } else {
            echo "<h2 style='color:blue; margin-top:1rem'>Wrong user e-mail / password</h2>";
        }
        $dbcon->close();
    }
    ?>


</body>

</html>