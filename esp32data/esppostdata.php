<?php
$connect = mysqli_connect('localhost','demo','123456','esp32');
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
$api_key_data = 'esp3212345';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $api_key = test_input($_POST["api_key"]);
  if($api_key_data == $api_key){
    $temperature = test_input($_POST["temperature"]);
    $humidity = test_input($_POST["humidity"]);
    $moisture = test_input($_POST["moisture"]);
    $pumper = test_input($_POST["pumper"]);
    $sql = "INSERT INTO `sensor` (`TEMPERATURE`, `HUMIDITY`, `MOISTURE`, `PUMPER`) VALUES ('$temperature', '$humidity', '$moisture', '$pumper')";

    if (mysqli_query($connect, $sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    }
    $connect->close();
  }
  else{
    echo "Wrong API Key";
  }
}
else{
  echo "no data";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>