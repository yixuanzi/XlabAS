import random
import os
import sys

for i in range(int(sys.argv[1])):
    flag=''
    for ii in range(32):
        flag+=chr(random.randint(97,122))
    if len(sys.argv)>2 and sys.argv[2]=='sql':
        print "insert into flag values (%d,'%s');" %(i+1,flag)
    else:
        print flag
    flag=''
    