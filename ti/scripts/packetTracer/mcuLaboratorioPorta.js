var DELAY_TIME = 1000;
var porta = A0;
var test = 0;
var RFID = A1;
var value_rfid = 0;
var http = new RealHTTPClient();
var url = "http://localhost/ti/api/api.php?nome=porta";
var urlPost = "http://localhost/ti/api/api.php";

function get_data_hora() {
    // Add +1 hour for Portugal timezone
    var data = new Date();
    var hora = data.getHours();
    data.setHours(hora + 1);

    var dateISO = data.toISOString();
    var data0 = dateISO.split('T')[0];
    var data1 = dateISO.split('T')[1];
    var time = data1.split('.')[0];
    var datahora = data0 + " " + time;
    return datahora;
}

function setup() {
    pinMode(porta, OUTPUT);
    pinMode(RFID, INPUT);

   
}

function loop() {
    if (analogRead(RFID) === 0) {
        value_rfid = 1;
    } else {
        value_rfid = 0;
    }

    // Post data to the API
    http.post(urlPost, {
        "nome": "porta",
        "valor": value_rfid,
        "hora": get_data_hora(),
        "tipo": 2
    });

    // Delay to ensure POST request is processed
    delay(DELAY_TIME);

    // Get the updated value from the API
    RealHTTPClient.get(url,  function (status, data) {
        if (status == 200) {
            Serial.println(data);
            if (data > 0)
                customWrite(porta, 1);
            else
                customWrite(porta, 0);
        } else {
            customWrite(porta, 0);
        }});

    // Delay before the next iteration
    delay(DELAY_TIME);
}
