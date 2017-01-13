#coding=utf8
from PIL import Image,ImageDraw,ImageFont
import matplotlib.pyplot as plt
import numpy
import os
import sys
import random

#get bit data from char
def getbit(bt,inx=0):
    if (inx>7):
        exit;
    if((bt & (1<<inx))>0):
        return 1;
    return 0;

def data2binlist(dt):
    binlist=[]
    for i in dt:
        asc=ord(i)
        binlist.append(getbit(asc,7))
        binlist.append(getbit(asc,6))
        binlist.append(getbit(asc,5))
        binlist.append(getbit(asc,4))
        binlist.append(getbit(asc,3))
        binlist.append(getbit(asc,2))
        binlist.append(getbit(asc,1))
        binlist.append(getbit(asc,0))
    binlist.extend((0,0,0,0,0,0,0,0))
    return binlist

def list2byte(lt):
    c=0
    if(len(lt)!=8):
        return
    for i in range(8):
        c+=(lt[i] << (7-i))
    return chr(c)

def binlist2data(binlist):
    if len(binlist)%8!=0:
        return
    dt=''
    for i in range(0,len(binlist),8):
        dt+=list2byte(binlist[i:i+8])
    
    return dt
    
#write data to image into bit
def write2image(img,binlist,mask=0b11111110):
    x,y=img.size
    bk=0
    if x*y < len(binlist):
        return -1
    binlist.reverse()
    dt=img.load()
    for yy in range(y):
        for xx in range(x):
            try:
                i=binlist.pop()
                dt[xx,yy]=(dt[xx,yy] & mask) + i
            except Exception:
                bk=1
                break
        if bk:
            break
    return img

#get data from image for bit
def getdata4image(img,mask=0b00000001,dlen=0):
    x,y=img.size
    binlist=[]
    dt=img.load()
    nums=0
    bk=0
    for yy in range(y):
        for xx in range(x):
            binlist.append(dt[xx,yy] & mask)
            nums+=1
            if dlen>0 and nums>=dlen:
                bk=1
                break
        if bk:
            break
    return binlist

if sys.argv[1]=='flag':
    img_r,img_g,img_b=Image.open("q12.png").split()
    blist=getdata4image(img_r,dlen=400)
    print blist
    flag=binlist2data(blist)
    print flag
    exit()
img_src=Image.open("q12_src.jpg")
#img_nm=numpy.array(img_src)

img_r,img_g,img_b=img_src.split()
binlist=data2binlist(sys.argv[1])
write2image(img_r,binlist)
img_new=Image.merge("RGB",(img_r,img_g,img_b))
img_new.save('q12.png',"PNG")
blist=getdata4image(img_r,dlen=len(sys.argv[1])*8)
flag=binlist2data(blist)
print flag
#plt.imshow(img_r)
#img_new=Image.fromarray(img_nm)
#plt.imshow(img_new)