var DELAY_TIME = 1000;
var tempPin = A0;
var humPin = A3;
var value = 0;
var http = new RealHTTPClient();
var url = "http://localhost/ti/api/api.php"


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
	pinMode(value, INPUT);
}

function loop() {
	// read from temp
	var newValue = analogRead(tempPin);

	// valores da temperatura do sensor: 0 a 1023
	// representa em ºC : -100ºC a 100ºC
	newValue = ((newValue*200)/1023)-100;
	
	// estrutura de decisão para apresentar apenas valores diferentes
	if (newValue != value) {
		//toFixed(2) » número com 2 casas décimais. 
		Serial.println("temperatura: " + newValue.toFixed(2));
		value = newValue;
		
		if(value > 20){
			http.post(url, {"nome":"luminosidade", "valor":value, "hora":get_data_hora(), "tipo":2});
		} else {
			http.post(url, {"nome":"luminosidade", "valor":value, "hora":get_data_hora(), "tipo":2});
		}
		
		//ENVIA PARA API
		http.post(url, {"nome":"temperatura", "valor":value, "hora":get_data_hora(), "tipo":1});
	}
	
	newValue = analogRead(tempPin);

	// valores da humidade do sensor: 0 a 1023
	// representa em % : 0 a 100%
	newValue = ((newValue*100)/1023);
	
	// estrutura de decisão para apresentar apenas valores diferentes
	if (newValue != value) {
		//toFixed(2) » número com 2 casas décimais. 
		Serial.println("humidade: " + newValue.toFixed(2) + "%");
		value = newValue;
		
		//ENVIA PARA API
		http.post(url, {"nome":"humidade", "valor":value, "hora":get_data_hora(),"tipo":1});
	}
	delay(DELAY_TIME);
	
	delay(DELAY_TIME);
}
