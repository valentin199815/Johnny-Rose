<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $dbcon = con_db();
        if($dbcon->connect_error){
            die("Connection:failed");
        }
        foreach($_SESSION["delete_input"] as $key => $val){
            if(isset($_POST[$key])){
              
                $delete="DELETE FROM `gallery_table` WHERE picture_id='".$key."'";
                $dbcon->query($delete);
                unlink($val);

            }
        }

        for($i=0;$i<100;$i++){
            if(isset($_FILES["up_pic".$i]["name"])){
                if(!empty($_FILES["up_pic".$i]["name"])){
                    $dir="./pages/gallery/".basename($_FILES["up_pic".$i]["name"]);
                    $extension=pathinfo($_FILES["up_pic".$i]["name"],PATHINFO_EXTENSION);
                    if($extension=="jpg" || $extension=="jpeg" || $extension=="png"){
                        pic_upload($_FILES["up_pic".$i]["tmp_name"],$dir);
                        $select="SELECT * FROM gallery_table WHERE picture_path='".$dir."'";
                        $result=$dbcon->query($select);
                        if($result->num_rows>0){
                            echo "Already uploaded";
                        }
                        else{
                            $insert="INSERT INTO gallery_table (picture_path) VALUES ('".$dir."')";
                            $result=$dbcon->query($insert);
                        }
                    }
                    else{
                        echo "File type should be jpg, jpeg, png";
                    }
                }  
            }
            else{
                break;
            }
        }
  
        $dbcon->close();
    }
?>

<div class="photo" id="photo">
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]."?addr=gallery"?>" enctype="multipart/form-data">
        <h2>Gallery</h2>
        <div>
            <?php
                 $dbcon = con_db();
                if($dbcon->connect_error){
                    die("Connection:failed");
                }
                $select="SELECT * FROM gallery_table WHERE 1";
                $result=$dbcon->query($select);
                $_SESSION["delete_input"]=[];
                if($result->num_rows>0){
                    $pic_count=1;
                    while($val=$result->fetch_assoc()){
                        echo "<div><h2>".$pic_count."</h2><img src='".$val["picture_path"]."'><label for='pic".$val["picture_id"]."'>Delete <input type='checkbox' name='".$val["picture_id"]."' id='".$val["picture_id"]."'></label></div>"; 
                        $_SESSION["delete_input"][$val["picture_id"]]=$val["picture_path"];
                        $pic_count++;
                    }
                }
                $dbcon->close();
            ?>
        </div>
        <div>
            <h3>Upload new picture</h3>
            <div id="upload_container">
            </div>
           
            <button type="button" id="add_upload">Add picture</button>
            <button type="submit">Update</button>
        </div>
    </form>
</div>
<script>
    let ele_upload=document.querySelector("#add_upload");
    let container_upload=document.querySelector("#upload_container");
    let count=0;
    ele_upload.addEventListener("click",()=>{
        let upload_ele=document.createElement("input");
        upload_ele.setAttribute("type","file");
        upload_ele.setAttribute("name",`up_pic${count}`);
        container_upload.appendChild(upload_ele);
        count++;
    });
</script>