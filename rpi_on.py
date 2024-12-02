#!/usr/bin/python
import RPi.GPIO as GPIO
pin = 31
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(pin, GPIO.OUT)
GPIO.output(pin, True)
