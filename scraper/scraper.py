#!/usr/bin/env python
"""
This is a module docstring
"""

import urllib2
import re
from bs4 import BeautifulSoup

def table2csv(html_txt):
    """
    This is a function docstring
    """
    csvs = []
    soup = BeautifulSoup(html_txt, "lxml")
    tables = soup.findAll('table')

    for table in tables:
        csv = ''
        rows = table.findAll('tr')
        row_spans = []
        do_ident = False

        for i, tr in enumerate(rows):
            if i == 0:  # skip the first row containing the column headers
                continue
            cols = tr.findAll(['th', 'td'])

            for cell in cols:
                colspan = int(cell.get('colspan', 1))
                rowspan = int(cell.get('rowspan', 1))

                if do_ident:
                    do_ident = False
                    csv += ','*(len(row_spans))

                if rowspan > 1:
                    row_spans.append(rowspan)

                csv += '"{text}"'.format(text=str(cell.text).strip()) + ','*(colspan)

            if row_spans:
                for i in xrange(len(row_spans)-1, -1, -1):
                    row_spans[i] -= 1
                    if row_spans[i] < 1:
                        row_spans.pop()

            do_ident = True if row_spans else False

            csv += '\n'

        csvs.append(csv)
        break#######################################################################################
    #print type(csvs)
    return '\n\n'.join(csvs)

directory = urllib2.urlopen("http://maktaba.tetea.org/exam-results/CSEE2015/")
dircontent = directory.read()
dirsoup = BeautifulSoup(dircontent, "lxml")
years = dirsoup.findAll('li')
for year in years:
    name = year.find('a').string.strip()
    #webpage = urllib2.urlopen("http://maktaba.tetea.org/exam-results/CSEE2015/{text}".format(text=year.find('a').string.strip()))
    #content = webpage.read()
    if re.search('^[p|s]', name):
        webpage = urllib2.urlopen("http://maktaba.tetea.org/exam-results/CSEE2015/{text}".format(text=name))
        content = webpage.read()
        print table2csv(content)
