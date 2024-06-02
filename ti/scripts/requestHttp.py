#requests 

import time
import requests

# r = requests.get('https://www.python.org')
# print(r.status_code) 


while(True):
    request = requests.get("http://iot.dei.estg.ipleiria.pt/api/api.php?sensor=btc")
    if(request.status_code == 200):
        print(time.strftime("%Y-%m-%d %H:%M:%S") + request.text)
    else:
        print("request error:" + request.status_code) 
    
    time.sleep(5)

# r = requests.post('https://httpbin.org/post', data={'key': 'value'})
# r = requests.put('https://httpbin.org/put', data={'key': 'value'})
# r = requests.delete('https://httpbin.org/delete')
# r = requests.head('https://httpbin.org/get')
# r = requests.options('https://httpbin.org/get')
