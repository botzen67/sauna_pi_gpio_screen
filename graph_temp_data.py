import urllib.request as url
from dateutil import parser
import datetime
import matplotlib.pyplot as plt
import pandas as pd

datafile = url.urlopen("http://hockeytownsauna.botzen.com/temp_record.dat")
data = []
for line in datafile:
    datapoint = line.strip().decode('utf-8')
    fields = datapoint.split("   ")
    timestamp = parser.parse(fields[0])
    temp = int(fields[1])
    onoff = int(fields[2])
    if temp > 1 and timestamp > datetime.datetime(2024,1,28,10):
        data.append((timestamp,temp))

# print(len(data))
df =  pd.DataFrame(data, columns = ['Date', 'Temp'])
# print(df)
plt.plot(df['Date'],df['Temp'])
plt.show()

    