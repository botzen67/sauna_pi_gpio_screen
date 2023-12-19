import os
import time


os.system("/usr/bin/gpio mode 25 out")
os.system("/usr/bin/gpio write 25 1")
time.sleep(3)
os.system("/usr/bin/gpio write 25 0")
