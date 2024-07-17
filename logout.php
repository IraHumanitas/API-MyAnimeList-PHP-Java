<?php

if(!empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $result = array();

    $con = mysqli_connect("localhost", "root", "", "andro_myanimelist");

    if($con){
        $sql = "SELECT * FROM users WHERE email = '$email' and apiKey = '$apiKey'";
        $res = mysqli_query($con, $sql);

        if(mysqli_num_rows($res) != 0){
            $row = mysqli_fetch_assoc($res);
            $sqlUpdate = "UPDATE users SET apiKey = '' where email = '$email'";

            if(mysqli_query($con, $sqlUpdate)){
                echo "success";
            } else echo "Logout failed";

        } else echo "Unauthorised to access";

    } else echo "database connection failed";

} else echo "All field are required";