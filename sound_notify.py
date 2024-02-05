import os
import time

tripped = True
while(True):
    
    # heater_on = os.stat("heater_status.dat").st_size != 0
    on_off = os.stat("on_off.dat").st_size != 0
    with open("set_point.dat") as file:
        set_point = int(file.readline())
    with open("temp.dat") as file:
        current_temp = int(file.readline())
    # print (on_off, heater_on, set_point, current_temp)
    
    if (not(tripped) and on_off and current_temp >= set_point):
        # print("Notifying!")    
        play_sound_command = "./sound_notify.sh"
        os.system(play_sound_command)
        time.sleep(30)
        os.system(play_sound_command)
        tripped = True
    
    if (tripped and current_temp < set_point and not(on_off)):
        tripped = False

    time.sleep(10)