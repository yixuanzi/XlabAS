import os
import sys

dt="mghiovaonyjfjpngtzzlxjzckkiiaknxhcctqcqyopmcmleaeojbcdopqjbiofwmlkfawjvyybxwxjqvcetmjxupmstqhjvompiiecjobmzqgzjoegwftrpndcmfuevchbtkqiqqesgzcegudjxeyljtxzmiduclztxjmdzheizktocdoobvywbfwjpzkqpovvogvffsmakpvtspaxonjliexyzplmfgykkolbojtbhedrztkosrgganqxpcgluykioxkkcjljlqlaikzqbdlbbmxzliaqnyqbvpniygugcrrjfmdtyawrybtzxmrbqqmbytbqroihkjjibshavkiwgumkcwnqgijctdhkgehbjyjplgyiqflfjktkbhwgpexlleucthhdjkvufsqygsshpwjacbgflitqteuddmddousbcnzsisoyeednvwveqaicuddctclddasnyqzpzmwhbrbbqrcqibviuxwlrttojtvahperssgrqyhacjyyqs"
status=0
group=0
flag=''
for i in dt:
    group+=ord(i)
    status+=1
    if status==16:
        flag+=dt[group%512]
        group=0
        status=0
print flag