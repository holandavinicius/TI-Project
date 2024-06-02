import time
import requests

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

        if(int(temperatura)> 20):
            print("Turn ON RPI LED")
        else:
            print("Turn OFF RPI LED")
        
        time.sleep(5)

    except Exception as e:
        print("Unexpected error:", e)
        
        



    
    