<?php
require_once("config.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM learning_demand WHERE ld_id = $id";
$result = mysqli_query($conn, $sql);

if(!$result){
    die("query ผิดพลาด");
}

$data = mysqli_fetch_assoc($result);

if(!$data){
    die("ไม่พบข้อมูล");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>แก้ไขข้อมูล</title>
</head>
<body>

<h2>แก้ไขข้อมูล</h2>

<form action="learning_demand_update.php" method="POST">

    <input type="hidden" name="id" value="<?= $data['ld_id'] ?>">

    วันที่:
    <input type="date" name="day" value="<?= $data['convenience_day'] ?>">
    <br>

    เวลา:
    <input type="number" name="time" value="<?= $data['convenience_time'] ?>">
    <br>

    <button type="submit">บันทึก</button>

</form>

</body>
</html>