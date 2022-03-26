<?php
    include "./cmd/pages/config.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Johnny and The Rose</title>
        <!--To adjast view port size -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--e To adjast view port size -->
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <!--I created folder for css and js changed path and add js -->
        <link rel="stylesheet" href="./css/styles.css">
        <script src="./js/jquery.js"></script>
        <!--e I created folder for css and js -->
        
        <script src="https://kit.fontawesome.com/0f63262170.js" crossorigin="anonymous"></script>
        <script src="https://your-site-or-cdn.com/fontawesome/v5.15.4/js/all.js" data-auto-a11y="true" ></script>
    </head>
    <body>
        <header id="home">
            <h1>JOHNNY AND THE <span>ROSE</span></h1>
            <nav>
                <a href="#home">Home</a>
                <a href="#bio">Bio</a>
                <a href="#photos">Photos</a>
                <a href="#events">Events</a>
                <a href="#contact">Contact</a>
            </nav>
        </header>
        <main>
            <section class="bio" id="bio">
                <img src="./img/9.jpeg">
                <div>
                    <h2>Who are we?</h2>
                    <?php
                        $dbcon = con_db();
                        if($dbcon->connect_error){
                            die("Connection:failed");
                        }
                        $select="SELECT * FROM bio_table WHERE 1";
                        $result=$dbcon->query($select);
                        if($result->num_rows>0){
                            while($row=$result->fetch_array()){
                                echo "<p>".$row["para_1"]."</p><p>".$row["para_2"]."</p><p>".$row["para_3"]."</p><p>".$row["para_4"]."</p>";
                            }
                        }
                    ?>
                    <div><button type="button">See Events</button></div>
                </div>
            </section>
            <section class="photos" id="photos">
                <h2>Gallery</h2>
                <div>
                    <!--modified-->
                    <?php
                        $dbcon = con_db();
                        if($dbcon->connect_error){
                            die("Connection:failed");
                        }
                        $select="SELECT * FROM gallery_table WHERE 1";
                        $result=$dbcon->query($select);
                        if($result->num_rows>0){
                            while($row=$result->fetch_array()){
                                echo "<div class='photos_img'>
                                    <img src='./cmd/".$row["picture_path"]."'>
                                </div>";
                            }
                        }
                    ?>
                    <!--e modified-->
                </div>
            </section>
            <section class="events" id="events">
                <h2>Events</h2>
                <div>
                    <?php
                        $dbconnect = con_db();
                        $selectdb = "SELECT * FROM `events_table`";
                        $result = $dbconnect->query($selectdb);
                            if($result-> num_rows >0){
                                while($row = $result->fetch_assoc()){
                                    echo "<div>";
                                        echo "<img src='./cmd/". $row["event_picture"]."'>";
                                        echo "<div>";
                                            echo "<p class='date'>". $row['event_date']."</p>";
                                            echo "<div>";
                                                echo "<p><i style='font-size:24px' class='fas'>&#xf3c5;</i>".$row['event_location']."</p>";
                                                echo "<p>". $row['event_description']."</p>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            }
                            $dbconnect->close();
                    ?>                    
                </div>
            </section>
            <section class="contact" id="contact">
                <img src="./img/11.jpeg">
                <form>
                    <h2>Contact us!</h2>
                    <label>Full name</label>
                    <input type="text" placeholder="Write your name">
                    <label>Email</label>
                    <input type="email" placeholder="Write your email">
                    <label>Message</label>
                    <textarea></textarea>
                    <div><button type="button">Send</button></div>
                    
                </form>
            </section>
        </main>
        <footer>
            <p>JOHNNY AND THE ROSE</p>
            <p>Keep in touch!</p>
            <div class="icons">
                <a href=""><i class="far fa-envelope"></i></a>
                <a href="" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <a href="" target="_blank"><i class="fab fa-pinterest"></i></a>

            </div>
        </footer>
        
        <script src="./js/index.js"></script>
    </body>
    
</html>