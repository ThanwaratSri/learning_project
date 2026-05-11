<?php
    require_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Demand</title>
</head>
<body>

<form action="learning_demand_list.php" method="post">
                <h2>ความต้องการเรียน</h2>
                <select name="subject">
                    <option value="">-- ระบุวิชา --</option>
                    <option value="1">ภาษาไทย</option>
                    <option value="2">คณิตศาสตร์</option>
                </select>
                <label for="availabledate">ระบุเวลาที่สะดวก :</label>
                <input type="date" name="availabledate">
                <select name="availabletime">
                    <option value="">-- ระบุช่วงเวลาที่สะดวก --</option>
                    <option value="1">07:00 - 08:00น.</option>
                    <option value="2">08:00 - 09:00น.</option>
                    <option value="3">09:00 - 10:00น.</option>
                    <option value="4">10:00 - 11:00น.</option>
                    <option value="5">11:00 - 12:00น.</option>
                    <option value="6">12:00 - 13:00น.</option>
                    <option value="7">14:00 - 15:00น.</option>
                    <option value="8">16:00 - 17:00น.</option>
                </select>
                <button type="submit" name="learner_submit">จับคู่</button>
            </form>
<?php

if(isset($_POST['learner_submit'])) {
    $userid = 1;
    $insubject = $_POST['subject'];
    $indate = $_POST['availabledate'];
    $intime = $_POST['availabletime'];


$sql = "INSERT INTO learning_demand (user_id, subject_id, convenience_day, convenience_time)
        VALUE ('$userid', '$insubject', '$indate', '$intime')";
$result = $conn->query($sql);

}

?>

<h2>ตารางข้อมูล</h2>

<?php 
$sql = "SELECT * FROM learning_demand";
$result = mysqli_query($conn, $sql);
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Subject</th>
        <th>วันที่</th>
        <th>เวลา</th>
        <th>จัดการ</th>
    </tr>

<?php
while($row = mysqli_fetch_assoc($result)){
?>
    <tr>
        <td><?= $row['ld_id'] ?></td>
        <td><?= $row['user_id'] ?></td>
        <td><?= $row['subject_id'] ?></td>
        <td><?= $row['convenience_day'] ?></td>
        <td><?= $row['convenience_time'] ?></td>
        <td>
            <a href="learning_demand_edit.php?id=<?= $row['ld_id'] ?>">แก้ไข</a>
            |
            <a href="learning_demand_delete.php?id=<?= $row['ld_id'] ?>"
               onclick="return confirm('ลบแน่นะ?')">ลบ
            </a>
        </td>
    </tr>
<?php
}

?>

</table>

</body>
</html>
