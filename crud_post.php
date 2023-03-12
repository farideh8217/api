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

$name = $data->name;
$age = $data->age;

$sql = "INSERT INTO `user`(`name`, `age`) VALUES (:name,:age)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":name",$name);
$stmt->bindParam(":age",$age);
$stmt->execute();
$result = "اطلاعات با موفقیت درج شد";
echo $result;


////////////////////
/// {
//    "name": "reza",
//    "age" : 33
//} به این صورت در postmanاطلاعات میفرسیم