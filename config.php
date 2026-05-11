<?php 
$conn = mysqli_connect("localhost", "root", "", "spmt_test");

if(!$conn){
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>
