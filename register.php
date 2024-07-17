<?php

if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {

    $con = mysqli_connect("localhost", "root", "", "andro_myanimelist");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if($con){
        $sql = "INSERT INTO user (name, email, password) VALUES ('$name','$email', '$password')";

        if(mysqli_query($con, $sql)){
            echo "success";
        } else echo "failed jir";
        
    } else echo "Connection Failed";

} else echo "all fields are required";