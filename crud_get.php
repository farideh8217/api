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


$name = $_GET["name"];
$age = $_GET["age"];

$sql = "INSERT INTO `user`(`name`, `age`) VALUES (:name,:age)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":name",$name);
$stmt->bindParam(":age",$age);
$stmt->execute();