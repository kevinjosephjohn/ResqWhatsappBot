#!/usr/bin/env python

import urllib2

if __name__ == '__main__':
    f = urllib2.urlopen('http://help.anoram.com/resqbot/smscheck.php')
    print f.read(10)