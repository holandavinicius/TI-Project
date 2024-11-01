from gpiozero import Buzzer
from time import sleep
import requests
import RPi.GPIO as GPIO

print("Prima CTRL+C para terminar")



buzzer = Buzzer(17)

while(True):
    try:
        result = requests.get("https://iot.dei.estg.ipleiria.pt/ti/g170/api/api.php?nome=temperatura")
        temperatura = ""

        if(result.status_code == 200):
            temperatura = result.text
            print(temperatura)
        
        if(temperatura == ""):
            break

        if(float(temperatura)> 10):
                buzzer.on()
                sleep(1)
                buzzer.off()
                sleep(1)
        
    except Exception as e:
        print("Unexpected error:", e)
        
        



    
    