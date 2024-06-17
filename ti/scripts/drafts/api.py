import time
import requests
import RPi.GPIO as GPIO

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


        if(int(temperatura)> 20):
            GPIO.output(channel, high)
        else:
            GPIO.output(channel, low)
        
        time.sleep(5)

    except Exception as e:
        print("Unexpected error:", e)
        
        



    
    