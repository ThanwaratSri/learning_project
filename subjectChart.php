<?php
require_once("config.php");

$sql = "SELECT YEAR(ld.convenience_day) AS year,
               s.subject_name,
               COUNT(ld.ld_id) AS total_requests
        FROM learning_demand ld
        JOIN subject s ON ld.subject_id = s.subject_id
        GROUP BY year, s.subject_name
        ORDER BY year ASC, s.subject_name ASC";

$result = mysqli_query($conn, $sql);

$subjects = [];
$dataByYear = [];

while($row = mysqli_fetch_assoc($result)){
    $year = $row['year'];
    $subject = $row['subject_name'];
    $count = $row['total_requests'];

    if(!in_array($subject, $subjects)){
        $subjects[] = $subject;
    }

    if(!isset($dataByYear[$year])){
        $dataByYear[$year] = [];
    }

    $dataByYear[$year][$subject] = $count;
}

// เติมค่า 0 ถ้าวิชานั้นไม่มีในปีนั้น
foreach($dataByYear as $year => $subjectCounts){
    foreach($subjects as $subject){
        if(!isset($dataByYear[$year][$subject])){
            $dataByYear[$year][$subject] = 0;
        }
    }
}

// กำหนดสีประจำวิชา
$subjectColors = [
    "ภาษาไทย" => "#2563EB",
    "คณิตศาสตร์" => "#10B981",
    "วิทยาศาสตร์" => "#F59E0B",
    "สังคม" => "#EF4444",
    "ภาษาอังกฤษ" => "#8B5CF6"
];

// เตรียม datasets เป็น array
$datasets = [];
foreach($dataByYear as $year => $subjectCounts){
    $datasets[] = [
        "label" => $year,
        "data" => array_values($subjectCounts),
        "backgroundColor" => array_map(function($subject) use ($subjectColors){
            return $subjectColors[$subject] ?? "#999999";
        }, $subjects)
    ];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายงานคำขอเรียนรายปี</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>กราฟจำนวนคำขอเรียนรายปี (Grouped Bar Chart)</h2>
<canvas id="subjectChart"></canvas>

<script>
const labels = <?php echo json_encode($subjects, JSON_UNESCAPED_UNICODE); ?>;
const datasets = <?php echo json_encode($datasets, JSON_UNESCAPED_UNICODE); ?>;

new Chart(document.getElementById('subjectChart'), {
  type: 'bar',
  data: {
    labels: labels,
    datasets: datasets
  },
  options: {
    responsive: true,
    plugins: {
      title: { display: true, text: 'จำนวนคำขอเรียนแยกตามวิชา (รายปี)' }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>

</body>
</html>