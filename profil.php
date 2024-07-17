<?php

if(!empty($_POST['email']) && !empty($_POST['apiKey'])) {

    $email = $_POST['email'];
    $apiKey = $_POST['apiKey'];
    $result = array();

    $con = mysqli_connect("localhost", "root", "", "andro_myanimelist");

    if($con){
        $sql = "SELECT * FROM users WHERE email = '$email' and apiKey = '$apiKey'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res) != 0){
            $row = mysqli_fetch_assoc($res);
            $result = array("status" => "success", 
                                "message" => "Data fetched sukses", 
                                "name" => $row['name'], 
                                "email" => $row['email'], 
                                "apiKey"=> $row['apiKey']);
        } else $result = array("status" => "failed", "message" => "retri with correct email and password");

    } else $result = array("status" => "failed", "message" => "Unauthorised access");

} else $result = array("status" => "failed", "message" => "All faeld are required");

echo json_encode($result, JSON_PRETTY_PRINT);