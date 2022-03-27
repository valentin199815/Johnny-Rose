<?php
    function con_db(){
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'johnnyandrose';
        $dbcon = new mysqli($servername, $username, $password, $database);
        return $dbcon;
    }
    function pic_upload($from,$to){
        move_uploaded_file($from,$to);
    }
?>