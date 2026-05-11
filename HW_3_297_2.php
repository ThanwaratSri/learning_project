<?php
require_once("config.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "DELETE FROM learning_demand WHERE ld_id = $id";

mysqli_query($conn, $sql);

header("Location: learning_demand_list.php");
exit();
?>