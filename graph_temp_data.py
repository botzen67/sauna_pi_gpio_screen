import urllib.request as url
from dateutil import parser
import datetime
import matplotlib.pyplot as plt
import matplotlib.dates as mdates
import pandas as pd

datafile = url.urlopen("http://hockeytownsauna.botzen.com/temp_record.dat")
data = []
for line in datafile:
    datapoint = line.strip().decode('utf-8')
    fields = datapoint.split("   ")
    timestamp = parser.parse(fields[0])
    temp = int(fields[1])
    onoff = int(fields[2])
    # if timestamp > datetime.datetime(2024,1,29,21,20) and timestamp < datetime.datetime(2024,1,29,23,15):
    if timestamp > datetime.datetime(2024,2,1,16,45) and timestamp < datetime.datetime(2024,2,1,23,00):
        data.append((timestamp,temp))

# print(len(data))
df =  pd.DataFrame(data, columns = ['Date', 'Temp'])
# print(df)
dtFmt = mdates.DateFormatter("%m/%d | %H:%M")
plt.gca().xaxis.set_major_formatter(dtFmt) 
plt.gca().xaxis.set_major_locator(mdates.MinuteLocator(interval=10))
plt.xticks(rotation=90, fontweight='light',  fontsize='x-small',)
plt.plot(df['Date'],df['Temp'])
plt.grid(True,'major','x')
plt.show()
