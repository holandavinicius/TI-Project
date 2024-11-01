var DELAY_TIME = 1000;
var smoke;
var value = 0;
var smoke_sensor = 0;
var fire_sprinkler = A1;
var door_actuator = A2;
var alarm = A3;
var http = new RealHTTPClient();
var urlSprinkler = "http://localhost/ti/api/api.php?nome=fumaca"
var urlPost = "http://localhost/ti/api/api.php"

function get_data_hora(){

	//para adicionar o fuso horário de Portugal +1. 
	var data = new Date();
	var hora = data.getHours();
	data.setHours(hora+1);
	
	//var dateISO = new Date().toISOString();
	var dateISO = data.toISOString();
	var data0 = dateISO.split('T')[0];
	var data1 = dateISO.split('T')[1];
	var time = data1.split('.')[0];
	var datahora = data0+" "+time;
	return datahora;
}



function setup() {
	pinMode(fire_sprinkler, OUTPUT);
	pinMode(smoke_sensor, INPUT);
	pinMode(alarm, OUTPUT);


	

	
}

function loop() {
	
	smoke = analogRead(smoke_sensor);
	Serial.println(analogRead(smoke_sensor));
	
	http.post(urlPost, {"nome":"fumaca", "valor":smoke, "hora":get_data_hora(), "tipo":1});

	
	
	RealHTTPClient.get(urlSprinkler, function(status, data) {
		
		//Serial.println("status: " + status);
		if (status == 200){
			Serial.println("data: " + data);
			if(data > 0){
				customWrite(fire_sprinkler,1);
				digitalWrite(alarm,HIGH);
				value = 1;
			}
			else{
				customWrite(fire_sprinkler,0);
				digitalWrite(alarm,LOW);
				value = 0;
			} 
				
				
			http.post(urlPost, {"nome":"sprinkler", "valor":value, "hora":get_data_hora(), "tipo":2});	
			// funcao customWrite permite escrever para o ecra uma string. 
		}else{
			customWrite(fire_sprinkler,0);
		}});
	
	

		
	delay(DELAY_TIME);
}
