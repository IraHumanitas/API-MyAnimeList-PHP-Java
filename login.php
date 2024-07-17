<?php

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $result = array();

    $con = mysqli_connect("localhost", "root", "", "andro_myanimelist");

    if ($con) {
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_assoc($res);
            if ($email == $row['email'] && password_verify($password, $row['password'])) {
                try {
                    $apiKey = bin2hex(random_bytes(23));
                } catch (Exception $e) {
                    $apiKey = bin2hex(uniqid($email, true));
                }

                $sqlUpdate = "UPDATE user SET apiKey = '$apiKey' where email = '$email'";

                if (mysqli_query($con, $sqlUpdate)) {
                    $row['apiKey'] = $apiKey;
                    $result = array(
                        "status" => "success",
                        "message" => "login sukses",
                        "name" => $row['name'],
                        "email" => $row['email'],
                        "apiKey" => $row['apiKey']
                    );
                } else {
                    $result = array("status" => "fail", "message" => "login failed");
                }
            } else {
                $result = array("status" => "fail", "message" => "retry with correct email and password");
            }
        } else {
            $result = array("status" => "fail", "message" => "retry with correct email and password");
        }
    } else {
        $result = array("status" => "fail", "message" => "database connection failed");
    }
} else {
    $result = array("status" => "fail", "message" => "all fields are required");
}

echo json_encode($result, JSON_PRETTY_PRINT);
