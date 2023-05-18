//esp32 lora receiver
//libraries
#include <SPI.h>
#include <LoRa.h>
#include <WiFi.h>
#include <WebServer.h>
#include <Arduino.h>
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <Wire.h>
#include <HTTPClient.h>

//Defining pins LoRa
#define ss 5
#define rst 34
#define dio0 4
#define sck 18
#define miso 19
#define mosi 23

#define BAND 433E6

float temperature;
float humidity;
int moisture;
bool led;
int messageid;
const char* ssid = "ok";
const char* password = "tqnguyen";
String apikey = "esp3212345";
String Servername = "http://localhost:3000/esppostdata.php";

String nameval1 = "temperature";
String nameval2 = "humidity";
String nameval3 = "moisure";
String nameval4 = "pumper";
String nameval5 = "messageid";
//connect wifi
void ConnectWifi()
{
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi ...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi ..");
  }
  Serial.println("Connected to the WiFi network");
}
//send data to server
void SendData()
{
    Serial.println("Sending data to server ...");
    HTTPClient http;
    http.begin("http://192.168.104.43/esp32data/esppostdata.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    String httpRequestData = "api_key=" + apikey + "&temperature=" + temperature + "&humidity=" + humidity + "&moisture=" + moisture + "&pumper=" + led;
    
    int httpResponseCode = http.POST(httpRequestData);
    if (httpResponseCode > 0) {
        String response = http.getString();
        Serial.println(httpResponseCode);
        Serial.println(response);
    }
    else {
        Serial.print("Error on sending POST: ");
        Serial.println(httpResponseCode);
    }
    http.end();
}
//start Lora
void StartLoRa()
{
   SPI.begin(sck, miso, mosi, ss);
  LoRa.setPins(ss, rst, dio0);
  while (!LoRa.begin(BAND)) {
    Serial.println("Starting LoRa failed!");
    delay(500);
  }
     LoRa.setSyncWord(0xF3);
    Serial.println("LoRa started!");
    
}
//Get data from LoRa
void GetData()
{
   // Serial.println("Getting data from LoRa ...");
  int packetSize = LoRa.parsePacket();
  //Serial.print(packetSize);
  if (packetSize) {
    // received a packet
    Serial.print("Received packet '");
    // read packet
    while (LoRa.available()) {
      String data = LoRa.readString();
        Serial.print(data);
        int index1 = data.indexOf("/");
        int index2 = data.indexOf("&");
        int index3 = data.indexOf("#");
        int index4 = data.indexOf("$");
        messageid = data.substring(0, index1).toInt();
        temperature = data.substring(index1 + 1, index2).toFloat();
        humidity = data.substring(index2 + 1, index3).toFloat();
        moisture = data.substring(index3 + 1, index4).toInt();
        led = data.substring(index4 + 1).toInt();
    }
    // print RSSI of packet
    Serial.print("' with RSSI ");
    Serial.println(LoRa.packetRssi());
    SendData();
  }
}
void setup() {
    Serial.begin(115200);
    ConnectWifi();
    StartLoRa();
    
   
}
void loop() {
    GetData();
  //delay(1000);
    //SendData();
  
}