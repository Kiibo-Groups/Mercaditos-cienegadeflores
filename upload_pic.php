<?php
    header('Access-Control-Allow-Origin: *');
    header("Content-type:multipart/form-data");
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    $target_path = "upload/users/";
    if (!file_exists("upload/users/")) {
      mkdir("upload/users/", 0777, true);
    }

    $target_path = $target_path .basename($_FILES['file']['name']);
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        echo true;
    } else {
        echo false;
    }
   
?>