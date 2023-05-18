
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <WebServer.h>
#include <Arduino.h>
#include <LoRa.h>
#include <SPI.h>

//Defining pins LoRa
#define ss 5
#define rst 34
#define dio0 4
#define sck 18
#define miso 19
#define mosi 23
#define BAND 433E6
#define DHTPIN 27     
#define DHTTYPE DHT11   // DHT 11
DHT dht(DHTPIN, DHTTYPE);
#define moisure 33
#define LED 25
#define us_to_sec 1000000
#define wake_up_time 15
int counter = 0;
float Readhumidity()
{
  float h = dht.readHumidity();
  if (isnan(h)) {
    Serial.println("Failed to read from DHT sensor!");
    return -1;
  }
  else {
    Serial.print("Humidity: ");
    Serial.println(h);
    return h;
  }
}
float Readtemperature()
{
  float t = dht.readTemperature();
  if (isnan(t)) {
    Serial.println("Failed to read from DHT sensor!");
    return -1;
  }
  else {
    Serial.print("Temperature: ");
    Serial.println(t);
    return t;
  }
}
int val;
unsigned long now2 ;
unsigned long timepassed2;
int Readmoisure()
{
  
  val = analogRead(26);
  Serial.println(val);
  val = (100 - ((val / 4095) * 100));
  Serial.println(val);
  return val;
}

void Pumperon()
{
  digitalWrite(LED, HIGH);
}
void Pumperoff()
{
  digitalWrite(LED, LOW); 
}
// read data from sensor and auto water
int timedelay= 3000;
unsigned long now ;
unsigned long timepassed;
void check_and_water()
{
  if(Readmoisure() < 30 || Readtemperature() > 33 || Readhumidity() < 55)
  {
    Pumperon(); 
    timepassed = millis();
    getReading();
    sendReading();
    while(1){
    
    now = millis();
    //now - timepassed >= timedelay
      if(now - timepassed >= timedelay)
      {
       timepassed = millis();
       if(Readmoisure() > 30){
        Pumperoff();
        break;
       }
      }
    }
  }
  else{
    getReading();
    sendReading();
  }
}

  bool ledstt;
  float humidity;
  float temperature;
  int moisture;
  int messegid = 0;
void getReading()
{
  humidity = Readhumidity();
  temperature = Readtemperature();
  moisture = Readmoisure();
  if(digitalRead(LED) == HIGH)
 {
   ledstt = true;
 }
 else
 {
   ledstt = false;
 }
 //sendReading();
}
String LoRaMessage = "";
void sendReading()
{
 // Serial.print("hi1");
  LoRaMessage = String(messegid) + "/" + String(temperature) + "&" + String(humidity) + "#" + String(moisture) + "$" + String(ledstt);
 // Serial.print("hi2");
  LoRa.beginPacket();

  LoRa.print(LoRaMessage);
  LoRa.endPacket();
  Serial.println(LoRaMessage);
  messegid++;
}
void StartLora()
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
int time_loop = 4000;
void esp32_wakeup()
{
 // unsigned long start_time = millis();
  //while(millis() - start_time <= time_loop)
 // {
    check_and_water();
 // }  
}

void setup(){
  Serial.begin(115200);
  dht.begin();
  pinMode(LED, OUTPUT);
  StartLora();
  esp32_wakeup();
  esp_sleep_enable_timer_wakeup(us_to_sec * wake_up_time);
  Serial.println("Going to sleep now");
  delay(1000);
  Serial.flush(); 
  esp_deep_sleep_start();  
}



void loop(){
  
  //getReading();
 
  //delay(100);
  //sendReading();
  //delay(2000);  
}