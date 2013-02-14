#!/usr/bin/env python
import sys
import os
import numpy as np
from matplotlib.mlab import griddata
import matplotlib.pyplot as plt
import random

def myfunc():
  temp = [random.normalvariate(50,20) for _ in xrange(100)]

  lat = ["{0:.6f}".format(random.uniform(40.25,40.46)) for _ in xrange(100)]
  long = ["{0:.6f}".format(random.uniform(-74.2,-74.40)) for _ in xrange(100)]
  
  x = np.random.randn(8873)
  y = np.random.randn(8873)
  '''
  plt.plot(lat, long, 'ro')

  plt.xlabel('latitude')
  plt.ylabel('longitude')
  plt.title('testing here')
  plt.grid(True)
  plt.savefig("test.png")
  plt.show()
  '''
  heatmap, xedges, yedges = np.histogram2d(x, y, bins=50)
  extent = [xedges[0], xedges[-1], yedges[0], yedges[-1]]

  plt.clf()
  plt.imshow(heatmap, extent=extent)
  plt.show()

    
def main():
  temp = [random.normalvariate(50,5) for _ in xrange(100)]

  lat = ["{0:.6f}".format(random.uniform(40.42,40.46)) for _ in xrange(100)]
  long = ["{0:.6f}".format(random.uniform(-74.36,-74.40)) for _ in xrange(100)]
  
  a = []
  f = open('testdata.txt','w')
  for i in xrange(100):
    a.append((lat[i],long[i],temp[i]))
    if i == 99:
      f.write(str(lat[i]) + ' ' + str(long[i]) + ' ' + str(temp[i])) #don't add newline on last entry
    else:
      f.write(str(lat[i]) + ' ' + str(long[i]) + ' ' + str(temp[i]) + '|')
    #print a[i]
  #print a[0]
  
        # f.write('{location: new google.maps.LatLng(' + str(lat[i]) + ', ' + str(long[i]) + '), weight: ' + str(temp[i]) + '}') #don't add newline on last entry
    # else:
      # f.write('{location: new google.maps.LatLng(' + str(lat[i]) + ', ' + str(long[i]) + '), weight: ' + str(temp[i]) + '},\n')
  
  # 'a' is of the format [(lats, lons, data), (lats, lons, data)... (lats, lons, data)]
  lats = [ x[0] for x in a ]
  lons = [ x[1] for x in a ]
  data = [ x[2] for x in a ]
  lat_min = min(lats)
  lat_max = max(lats)
  lon_min = min(lons)
  lon_max = max(lons)
  data_min = min(data)
  data_max = max(data)

  fig = plt.figure()

  ngrid = 500
  x = np.array(lats)
  y = np.array(lons)
  z = np.array(data)
 
  xi = np.linspace(lat_min, lat_max, ngrid)
  yi = np.linspace(lon_min, lon_max, ngrid)
  xi, yi = np.meshgrid(xi, yi)
  zi = griddata(x, y, z, xi, yi)
         
  # draw the map
  plt.xlim(lat_min, lat_max)
  plt.ylim(lon_min, lon_max)
  cs = plt.contourf(xi, yi, zi, 20, linewidths=1)
  plt.scatter(x, y, c=z, s=20)
  plt.colorbar(cs, shrink = 0.8, extend="both")

  plt.show()
  
if __name__ == '__main__':
  main()