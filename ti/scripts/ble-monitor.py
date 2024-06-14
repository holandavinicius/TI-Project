import bluepy.btle as bluepy
import time
import RPI.GPIO as GPIO



class FindDevices(bluepy.DefaultDelegate):
    def handleDiscovery(self,dev, isNewDev, isNewData):
        if(dev.addr == "6d:68:d5:66:a4:0d"):
            print("We find a new device", dev.addr, " RSSI:", dev.rssi)
            GPIO.setmode(GPIO.BCM)
            channel = 2
            GPIO.setup(channel,GPIO.OUT)
            GPIO.outpu(channel, 1)
            time.sleep(1)
            GPIO.outpu(channel, 0)



scanner = bluepy.Scanner().withDelegate(FindDevices())

devices = scanner.scar(10,passive=True)

