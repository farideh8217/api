<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=api_php", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$json = file_get_contents('php://input');
$data = json_decode($json);

$username = $data->username;
$password = $data->password;
$email = $data->email;


if(empty($username))
    $error = 'username must not be empty';
else if(empty($password))
    $error = 'password must not be empty';
else if(empty($email))
    $error = 'email must not be empty';
else{
    $query = 'SELECT * FROM user WHERE email = ?';
    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if($user === false){
        $insertQuery = "INSERT INTO user (`username`, `password`, `email`) VALUE (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $password = password_hash($password,PASSWORD_DEFAULT);
        $result = $stmt->execute([$username, $password, $email]);
        if($result)
        {
            $response['status'] = true;
            $response['message'] = 'کاربر با موفقیت ساخته شد';
        }
        else{
            $response['status'] = false;
            $response['message'] = 'در حین ثبت نام مشکلی پیش آمد';
        }

    }
    else{
        $response['status'] = false;
        $response['message'] = 'کاربر تکراری میباشد';
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
if(isset($error))
     echo json_encode($error);