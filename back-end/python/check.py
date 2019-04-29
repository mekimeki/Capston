import matplotlib.pyplot as plt
import numpy as np
import math

Fs = 16000 #샘플링 주파수
T = 1/Fs # 초당 측정 시간
te = 0.5 # 시간 끝
t = np.arange(0, te, T) #시간 백터

noise = np.random.normal(0, 0.05, len(t))
x = 0.6 * np.cos(2*np.pi*60*np.pi/2) + np.cos(2*np.pi*120*t)
y = x + noise

plt.figure(num = 1, dpi=100, facecolor='white')
plt.plot(t,y,'r')
plt.xlim(0, 0.05)
plt.xlabel('time($sec$)')
plt.ylabel('y')
plt.show()