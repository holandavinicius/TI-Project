import time
import requests
import time
import RPi.GPIO as GPIO
import datetime



print("Prima CTRL+C para terminar")

while(True):
    try:
        result = requests.get("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php?nome=temperatura")
        temperatura = ""

        if(result.status_code == 200):
            temperatura = result.text
            print(temperatura)
        
        if(temperatura == ""):
            break

        GPIO.setmode(GPIO.BCM)
        channel = 2

        GPIO.setup(channel,GPIO.OUT)

        high = 1
        low = 0

        hora = datetime.datetime.now()
        nome = "luminosidade"
        valor = '1'

        

        if(int(temperatura)> 15):
            GPIO.output(channel,high)
            valor = '1'
            payload = {'nome' :  nome ,'valor': valor , 'hora' : hora, 'tipo':1}
            r = requests.post("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php", data=payload)    
        else:
            GPIO.output(channel,low)
            valor = '0'
            payload = {'nome' :  nome ,'valor': valor , 'hora' : hora, 'tipo':1}
            r = requests.post("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php", data=payload)    
        

        result = requests.get("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php?nome=humidade")
        humidade = ""

        if(result.status_code == 200):
            humidade = result.text
            print(humidade)
        
        if(humidade == ""):
            break

        if(int(humidade)> 30):
            GPIO.output(channel,high)
            valor = '1'
            payload = {'nome' :  nome ,'valor': valor , 'hora' : hora, 'tipo':1}
            r = requests.post("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php", data=payload)    
        else:
            GPIO.output(channel,low)
            valor = '0'
            payload = {'nome' :  nome ,'valor': valor , 'hora' : hora, 'tipo':1}
            r = requests.post("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php", data=payload)    

        time.sleep(1)

    except Exception as e:
        print("Unexpected error:", e)
        
        



    
    
