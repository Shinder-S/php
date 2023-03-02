<?php

    function upload_image(){
        if(isset($_FILES["imageUser"])){
            $extension = explode('.',$_FILES["imageUser"]['name']);
            $new_name = rand() . '.' . $extension[1];
            $location = './img/' . $new_name;
            move_uploaded_file($_FILES["imageUser"]['tmp_name'],
            $location);
            return $new_name;
        }
    }

    function get_image_name($id_user){
        include('connection.php');
        $stmt = $connection->prepare("SELECT image FROM users 
        WHERE id = '$id_user");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row){
            return $row["image"];
        }
    }

    function get_all_records(){
        include('connection.php');
        $stmt = $connection->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $stmt->rowCount();
    }

?>