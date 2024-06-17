#include <SPI.h>
#include <WiFi101.h>
#include <ArduinoHttpClient.h>
#include "arduino_secrets.h" 
///////please enter your sensitive data in the Secret tab/arduino_secrets.h
char ssid[] = SECRET_SSID;        // your network SSID (name)
char pass[] = SECRET_PASS;    // your network password (use for WPA, or use as key for WEP)
int keyIndex = 0;            // your network key Index number (needed only for WEP)

int status = WL_IDLE_STATUS;
// if you don't want to use DNS (and reduce your sketch size)
// use the numeric IP instead of the name for the server:
//IPAddress server(74,125,232,128);  // numeric IP for Google (no DNS)

char URL[] = "iot.dei.estg.ipleiria.pt";
int PORTO = 80; // ou outro porto que esteja definido no servido

// Initialize the Ethernet client library
// with the IP address and port of the server
// that you want to connect to (port 80 is default for HTTP):

WiFiClient clienteWifi;
HttpClient clienteHTTP = HttpClient(clienteWifi, URL, PORTO);


char URL_API_POST[] = "http://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php";

char CONTENT_TYPE[] = "application/x-www-form-urlencoded";


void setup() {
   //Initialize serial and wait for port to open:
  Serial.begin(9600);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }

  // check for the presence of the shield:
  if (WiFi.status() == WL_NO_SHIELD) {
    Serial.println("WiFi shield not present");
    // don't continue:
    while (true);
  }

  // attempt to connect to WiFi network:
  while (status != WL_CONNECTED) {
    Serial.print("Attempting to connect to SSID: ");
    Serial.println(ssid);
    // Connect to WPA/WPA2 network. Change this line if using open or WEP network:
    status = WiFi.begin(ssid, pass);

    // wait 10 seconds for connection:
    delay(10000);
  }
  
   Serial.println("Connected to wifi");
   //printWiFiStatus();


}



void loop() {

  String URLPath = "/ti/g170/api/api.php"; //altere o grupo
  String contentType = "application/x-www-form-urlencoded";


  String enviaNome = "temperatura";
  String enviaValor = "38";
  String enviaHora = "2024-05-03 12:32:00";

  String body = "nome="+enviaNome+"&valor="+enviaValor+"&hora="+enviaHora;


  clienteHTTP.post(URLPath, contentType, body);

  while(clienteHTTP.connected()){
    if(clienteHTTP.available()){
        int responseStatusCode = clienteHTTP.responseStatusCode();
        String responseBody = clienteHTTP.responseBody();
        Serial.println("Status Code: " + String(responseStatusCode) + " Response:" + responseBody);
    }
  }

  delay(5000);
}


void printWiFiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}
