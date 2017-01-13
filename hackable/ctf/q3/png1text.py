#coding=utf8
from PIL import Image,ImageDraw,ImageFont
import os
import sys

src=Image.open("sword.jpg")
font = ImageFont.truetype('simsun.ttc',20)
d=ImageDraw.Draw(src)
d.text((0,0),sys.argv[1],(0,0,0),font)
src.save("flag3.jpg",'JPEG')
