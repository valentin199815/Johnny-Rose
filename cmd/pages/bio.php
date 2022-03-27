<?php
  $dbcon = con_db();
  if($dbcon->connect_error){
      die("Connection:failed");
  }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
    $update="UPDATE bio_table SET para_1='".$_POST["first_para"]."',para_2='".$_POST["second_para"]."',para_3='".$_POST["third_para"]."',para_4='".$_POST["Four_para"]."' WHERE bio_id=1";
    $result=$dbcon->query($update);
    }

  $select="SELECT * FROM bio_table WHERE bio_id=1";
  $result=$dbcon->query($select);
  if($result->num_rows>0){
      while($val=$result->fetch_assoc()){
          $SESSION["p1"]=$val["para_1"];
          $SESSION["p2"]=$val["para_2"];
          $SESSION["p3"]=$val["para_3"];
          $SESSION["p4"]=$val["para_4"];
      }
  }

    $dbcon->close();

?>

<div class="bio" id="bio">
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]."?addr=bio"?>" ><!--need to change action-->
        <h2>Edit BIO</h2>
        <div>
            <div>
                <label for="first_para">1st paragraph</label>
                <textarea name="first_para" id="first_para" style="text-align: left;"><?php
                        if(isset($SESSION["p1"])){
                            echo $SESSION["p1"];
                        }
                    ?>
                </textarea>
            </div>
            <div>
                <label for="second_para">2nd paragraph</label>
                <textarea name="second_para" id="second_para"
                    ><?php
                        if(isset($SESSION["p2"])){
                            echo $SESSION["p2"];
                        }
                    ?>
                </textarea>
            </div>
            <div>
                <label for="third_para">3rd paragraph</label>
                <textarea name="third_para" id="third_para"
                    ><?php
                        if(isset($SESSION["p3"])){
                            echo $SESSION["p3"];
                        }
                    ?>
                </textarea>
            </div>
            <div>
                <label for="Four_para">4th paragraph</label>
                <textarea name="Four_para" id="Four_para"
                    ><?php
                        if(isset($SESSION["p4"])){
                            echo $SESSION["p4"];
                        }
                    ?>
                </textarea>
            </div>
        </div>
        <button type="submit">Edit</button>
    </form>
</div>