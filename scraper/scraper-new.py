#!/usr/bin/env python
"""
This is a module docstring
"""
from __future__ import print_function
import urllib2
import re
from bs4 import BeautifulSoup

def table2csv(html):
    """
    Scrapes an HTML document and prints the contents of
    enclosed tables formatted as CSV
    """
    soup = BeautifulSoup(html, "lxml")
    tables = soup.findAll('table')

    for table in tables:
        rows = table.findAll('tr')
        for row in rows[1:]:
            cols = row.findAll(['th', 'td'])
            for cell in cols:
                print('"{text}",'.format(text=cell.find('p').string.strip()), end="")
            print()
        break#################################################################################################################################

directory = urllib2.urlopen("http://maktaba.tetea.org/exam-results/CSEE2015/")
dircontent = directory.read()
dirsoup = BeautifulSoup(dircontent, "lxml")
years = dirsoup.findAll('li')
for year in years:
    name = year.find('a').string.strip()
    if re.search('^[p|s]', name):
        webpage = urllib2.urlopen("http://maktaba.tetea.org/exam-results/CSEE2015/{text}".format(text=name))
        content = webpage.read()
        table2csv(content)
