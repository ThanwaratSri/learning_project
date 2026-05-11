<?php
require_once("config.php");

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$day = isset($_POST['day']) ? $_POST['day'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';

if($id <= 0 || empty($day) || empty($time)){
    die("ข้อมูลไม่ครบ");
}

$day = mysqli_real_escape_string($conn, $day);
$time = mysqli_real_escape_string($conn, $time);

$sql = "UPDATE learning_demand 
        SET convenience_day = '$day',
            convenience_time = '$time'
        WHERE ld_id = $id";

if(!mysqli_query($conn, $sql)){
    die("แก้ไขข้อมูลไม่สำเร็จ");
}

header("Location: learning_demand_list.php");
exit();
?>