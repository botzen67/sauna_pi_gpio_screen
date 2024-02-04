import os
import time

tripped = False
while(True):
    
    heater_on = os.stat("heater_status.dat").st_size != 0
    on_off = os.stat("on_off.dat").st_size != 0
    with open("set_point.dat") as file:
        set_point = int(file.readline())
    with open("temp.dat") as file:
        current_temp = int(file.readline())
    trip_point = set_point - 7
    print (on_off, heater_on, set_point, current_temp)
    
    if (not(tripped) and heater_on and current_temp > trip_point):
        print("Notifying!")    
        # play_sound_command = "aplay bleep_01.wav"
        play_sound_command = "./sound_notify.sh"
        os.system(play_sound_command)
        tripped = True
    
    if (current_temp < trip_point):
        tripped = False

    time.sleep(10)