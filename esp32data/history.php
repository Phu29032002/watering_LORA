<!DOCTYPE html> 
<html> 
	<head> 
		<title> Fetch Data From Database </title> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
  function updateData() {
    $.ajax({
    type: 'GET',
    url: 'data2.php',
    data: {
        lastRecordId: lastRecordId // Pass the lastRecordId to the PHP script
    },
    dataType: 'json',
    success: function(data) {
        if (data !== null) {
            appendTableRow(data);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown);
    }
    });
  }
  function appendTableRow(data) {
                var newRow = '<tr>' +
                    '<td>' + data.id + '</td>' +
                    '<td>' + data.temperature + '</td>' +
                    '<td>' + data.humidity + '</td>' +
                    '<td>' + data.moisture + '</td>' +
                    '<td>' + data.pump_status + '</td>' +
                    '<td>' + data.reading_time + '</td>' +
                    '</tr>';

                $('table').append(newRow);
            }

  setInterval(updateData, 1000);
});
    </script>
		<style>
			html {font-family: Arial; display: inline-block; text-align: center;}
			p {font-size: 1.2rem;}
			body {margin: 0;}
			.logo {overflow: hidden; background-color: #6C0BA9; color: white; font-size: 1.7rem;}
			.container {padding: 20px; }
		</style>
	</head> 
	<body> 
		<div class="logo">
			<h2>ESP32 DHT11</h2>
		 </div>
		 <div class="container">
	<table align="center" border="1px" style="width:600px; line-height:40px;"> 
	<tr> 
		<th colspan="6"><h2>Record</h2></th> 
		</tr> 
        <tr>
			    <th> ID </th> 
			    <th> TEMPERATURE </th> 
			    <th> HUMIDITY </th>
                <th> MOISTURE </th> 
			    <th> PUMP </th>
                <th> TIME </th>   
		</tr> 
        <?php
$connect = mysqli_connect('localhost','demo','123456','esp32');
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
$sql = "SELECT * FROM sensor";
$result = mysqli_query($connect,$sql);
while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";
    echo "<td>" . $row['ID'] . "</td>";
    echo "<td>" . $row['TEMPERATURE'] . "</td>";
    echo "<td>" . $row['HUMIDITY'] . "</td>";
    echo "<td>" . $row['MOISTURE'] . "</td>";
    echo "<td>" . $row['PUMPER'] . "</td>";
    echo "<td>" . $row['READING_TIME'] . "</td>";
    echo "</tr>";
}
mysqli_close($connect);
    
?>
    </table> 
</div>
</body> 
</html>