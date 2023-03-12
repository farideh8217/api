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

$id = $_GET["id"]; /////آیدی رو هیچ موقع در جیسون نمیفرستند ودر گت میگذارند

$sql = "UPDATE `user` SET `name`=:name WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":name",$name);
$stmt->bindParam(":id",$id);
$stmt->execute();
$result = "اطلاعات با موفقیت ویرایش شد";
echo $result;

////متر روی put گذاشته شد