// #include <SPI.h>
// #include <WiFi101.h>
// #include <DHT.h>
// #include <ArduinoHttpClient.h>
// #include <RTCZero.h>
// #include <WiFiUdp.h>
// #include <NTPClient.h>

// // Replace with your network credentials
// char ssid[] = "labs";
// char pass[] = "1nv3nt@r2023_IPLEIRIA";

// // API endpoint details
// char serverAddress[] = "iot.dei.estg.ipleiria.pt";  // Example: "example.com"
// int port = 80;
// String endpoint = "/ti/g170/api/api.php";

// // Initialize DHT sensor
// #define DHTPIN 2     // Digital pin connected to the DHT sensor
// #define DHTTYPE DHT11   // DHT 11 (you can also use DHT22)
// DHT dht(DHTPIN, DHTTYPE);

// // Initialize RTC
// RTCZero rtc;

// // Initialize WiFi and HTTP clients
// WiFiClient wifi;
// HttpClient client = HttpClient(wifi, serverAddress, port);

// // Initialize NTP client
// WiFiUDP ntpUDP;
// NTPClient timeClient(ntpUDP, "pool.ntp.org", 0, 60000);  // Update every minute

// void setup() {
//   // Start serial communication
//   Serial.begin(9600);
//   while (!Serial);

//   // Connect to Wi-Fi
//   Serial.print("Connecting to ");
//   Serial.println(ssid);
//   int status = WiFi.begin(ssid, pass);

//   while (status != WL_CONNECTED) {
//     Serial.print(".");
//     delay(1000);
//     status = WiFi.status();
//   }

//   Serial.println("Connected to Wi-Fi");
//   Serial.print("IP address: ");
//   Serial.println(WiFi.localIP());

//   // Initialize DHT sensor
//   dht.begin();

//   // Initialize RTC
//   rtc.begin();

//   // Initialize and synchronize NTP client
//   timeClient.begin();
//   while (!timeClient.update()) {
//     timeClient.forceUpdate();
//   }
//   unsigned long epochTime = timeClient.getEpochTime();

//   // Set the RTC with the obtained NTP time
//   rtc.setEpoch(epochTime);
// }

// void loop() {
//   // Wait a few seconds between measurements
//   delay(2000);

//   // Reading temperature or humidity takes about 250 milliseconds!
//   float humidity = dht.readHumidity();
//   // Read temperature as Celsius (the default)
//   float temperature = dht.readTemperature();

//   // Check if any reads failed and exit early (to try again).
//   if (isnan(humidity) || isnan(temperature)) {
//     Serial.println("Failed to read from DHT sensor!");
//     return;
//   }




//   // Get the current date and time from the RTC
//   char datetime[20];
//   sprintf(datetime, "%04d-%02d-%02d %02d:%02d:%02d", 
//           rtc.getYear(), 
//           rtc.getMonth(), 
//           rtc.getDay(), 
//           rtc.getHours(), 
//           rtc.getMinutes(), 
//           rtc.getSeconds());

//   // Print the results
//   Serial.print("Humidity: ");
//   Serial.print(humidity);
//   Serial.print(" %\t");
//   Serial.print("Temperature: ");
//   Serial.print(temperature);
//   Serial.print(" *C\t");
//   Serial.print("DateTime: ");
//   Serial.println(datetime);

//  // Create plain text payload
//   String payload = "nome=temperatura";
//   payload += "&valor="
//   payload += temperature;
//   payload += "&hora="
//   payload += datetime;

//  // Post data to the API endpoint temperatura
//   client.beginRequest();
//   client.post(endpoint);
//   client.sendHeader("Content-Type", "application/x-www-form-urlencoded");
//   client.sendHeader("Content-Length", payload.length());
//   client.beginBody();
//   client.print(payload);
//   client.endRequest();

//   // Get the response
//   int statusCode = client.responseStatusCode();
//   String response = client.responseBody();
//   if(statusCode == 200){
//       Serial.print("Temperatura enviada!")
//       Serial.print("Response: ");
//       Serial.println(response);
//   }


//   String payload = "nome=humidade";
//   payload += "&valor="
//   payload += humidity;
//   payload += "&hora="
//   payload += datetime;

 
//   // Post data to the API endpoint humidade
//   client.beginRequest();
//   client.post(endpoint);
//   client.sendHeader("Content-Type", "application/x-www-form-urlencoded");
//   client.sendHeader("Content-Length", payload.length());
//   client.beginBody();
//   client.print(payload);
//   client.endRequest();

//   if(statusCode == 200){
//         Serial.print("humidade enviada!")
//         Serial.print("Response: ");
//         Serial.println(response);
//     }


// }
