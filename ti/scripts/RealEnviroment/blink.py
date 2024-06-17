import time
import RPi.GPIO as GPIO


#TEST ON

# GPIO.setmode(GPIO.BOARD)
  # or


#GND GPIO 5 PIN 9


#To detect which pin numbering system has been set (for example, by another Python module):
# mode = GPIO.getmode()
GPIO.setmode(GPIO.BCM)
channel = 3
GPIO.setup(channel,GPIO.OUT)


print(GPIO.input(channel))
#STATE
#0 - GPIO.LOW
#1 - GPIO.HIGH

high = 1
low = 0

GPIO.output(channel,high)
time.sleep(3)
'''
while(True):
    try:
        GPIO.output(channel,high)
        time.sleep(1)
        GPIO.output(channel,low)
    except KeyboardInterrupt:
        print('\n The program was interrupted by user.')
        break
    except Exception as e:
        print("Exited",e)
        break
    finally:
        GPIO.cleanup(channel)
        print("End of program.")



'''