import bluepy.btle as bluepy
import time
import RPI.GPIO as GPIO



class FindDevices(bluepy.DefaultDelegate):
    def handleDiscovery(self,dev, isNewDev, isNewData):
        print("We find a new device", dev.addr, " RSSI:", dev.rssi)
           



scanner = bluepy.Scanner().withDelegate(FindDevices())

devices = scanner.scar(10,passive=True)

