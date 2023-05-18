<?php
$connect = mysqli_connect('localhost','demo','123456','esp32');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$sql1 = "SELECT * FROM sensor WHERE ID = (SELECT MAX(ID) FROM sensor)";
if ($result = mysqli_query($connect, $sql1)) {
  $row = mysqli_fetch_assoc($result);
  $data = array(
    'temperature' => $row['TEMPERATURE'],
    'humidity' => $row['HUMIDITY'],
    'moisture' => $row['MOISTURE'],
    'pump_status' => $row['PUMPER'],
    'reading_time' => $row['READING_TIME']
  );
  echo json_encode($data);
} else {
  echo "Error: " . mysqli_error($connect);
}

mysqli_close($connect);
?>