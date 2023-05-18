<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ESP32</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="icon" href="data:,">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
  function updateData() {
    $.ajax({
      type: 'GET',
      url: 'data.php',
      dataType: 'json',
      success: function(data) {
        console.log(data);
        $('#temp1').html(data.temperature);
        $('#humd1').html(data.humidity);
        $('#moi1').html(data.moisture);
        $('#pump_status').html(data.pump_status);
        $('#LTRD_ESP32_1').html(data.reading_time);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown);
      }
    });
  }

  setInterval(updateData, 5000);
});
    </script>

<style>

html {font-family: Arial; display: inline-block; text-align: center;}
p {font-size: 1.2rem;}
body {margin: 0;}
.logo {overflow: hidden; background-color: #6C0BA9; color: white; font-size: 1.7rem;}
.container {padding: 20px; }
.card {background-color: white; box-shadow: 0px 0px 10px 1px rgba(140,140,140,.5); border: 1px solid #6C0BA9; border-radius: 15px;}
.card.header {background-color: #6C0BA9; color: white; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px; border-top-right-radius: 12px; border-top-left-radius: 12px;}
.cards {max-width: 700px; margin: 0 auto; grid-gap: 2rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));}
.reading {font-size: 2.8rem;}
.packet {color: #bebebe;}
.temperatureColor {color: #fd7e14;}
.humidityColor {color: #1b78e2;}
.moisureColor {color: #1b78e2;}
.statusreadColor {color: #183153; font-size:15px;}
</style>

</head>
<body>
<div class="logo">
     <h2>ESP32 DHT11</h2>
  </div>
  <br>
  <div class="container">
    <div class="cards">
      <div class="card">
        <div class="cardheader">
          <h2>ESP32 1</h2>
        </div>
        <br>
        <h4 class="temperature"><i class="fas fa-thermometer-half"></i> TEMPERATURE</h4>
          <p class="temperature"><span class="reading"><span id="temp1"></span>&deg;C</span></p>
          <h4 class="humidityColor"><i class="fas fa-tint"></i> HUMIDITY</h4>
          <p class="humidityColor"><span class="reading"><span id="humd1"></span>  &percnt;</span></p>
          <h4 class="moisureColor"><i class="fas fa-tint"></i> Moisure</h4>
          <p class="moisureColor"><span class="reading"><span id="moi1"> </span> &percnt;</span></p>
          <p class="statusreadColor"><span>Pumper: </span><span id="status_read_DHT11_ESP32_1"><button onclick="pump()"><span id="pump_status"></span></button></span></p>
          <p class="statusreadColor" ><span>Last time to receive data : </span><span id="LTRD_ESP32_1" ></span></p>
          </div>
        </div>
        </div>


</body>
</html>


