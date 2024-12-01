import RPi.GPIO as GPIO
pin = 38
GPIO.setmode(GPIO.BOARD)
GPIO.setup(pin, GPIO.OUT)
done = False
while not done:
	opt = input("Enter Command:")
	if opt == "q":
		done = True
	elif opt == "0":
		GPIO.output(pin, False)
	elif opt == "1":
		GPIO.output(pin, True)
GPIO.cleanup()
