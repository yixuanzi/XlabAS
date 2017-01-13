import os
import sys
p=sys.argv[1]
s=sys.argv[2]

d=open(p,'rb').read()
open(s,'w').write(d.encode('hex'))