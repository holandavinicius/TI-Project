var DELAY_TIME = 1000;
var value_rfid = 0;
var value_motion = 0;
var movimento = 0;
var camera_pin = 2;
var leitor_RFID = A0;
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
	pinMode(movimento, INPUT);
	pinMode(leitor_RFID, INPUT);
	pinMode(camera_pin, OUTPUT);
}

function loop() {
	
	
	if(analogRead(leitor_RFID) === 0){
		value_rfid = 1;
		
	}
	else{
		value_rfid = 0;
		
	}
	
	if(digitalRead(movimento) === 0){
		value_motion = 0;
		customWrite(camera_pin,0);
	}
	else{
		value_motion = 1;
		customWrite(camera_pin,1);
		
	}
	
	http.post(url, {"nome":"cancela", "valor":value_rfid, "hora":get_data_hora(), "tipo":2});
	
	http.post(url, {"nome":"movimento", "valor":value_motion, "hora":get_data_hora(),"tipo":1});
	
	delay(DELAY_TIME);
	
}
