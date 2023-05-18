<?php
$connect = mysqli_connect('localhost', 'demo', '123456', 'esp32');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$lastRecordId = $_GET['lastRecordId']; // Get the last displayed record ID from JavaScript

$sql = "SELECT * FROM sensor WHERE ID > $lastRecordId ORDER BY ID ASC LIMIT 1";
if ($result = mysqli_query($connect, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $data = array(
            'id' => $row['ID'],
            'temperature' => $row['TEMPERATURE'],
            'humidity' => $row['HUMIDITY'],
            'moisture' => $row['MOISTURE'],
            'pump_status' => $row['PUMPER'],
            'reading_time' => $row['READING_TIME']
        );
        echo json_encode($data);
    } else {
        echo json_encode(null); // No new rows to append
    }
} else {
    echo "Error: " . mysqli_error($connect);
}

mysqli_close($connect);
?>