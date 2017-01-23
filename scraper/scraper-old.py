#!/usr/bin/env python

from bs4 import BeautifulSoup
import urllib2

def table2csv(html_txt):
   csvs = []
   soup = BeautifulSoup(html_txt, "lxml")
   tables = soup.findAll('table')

   for table in tables:
       csv = ''
       rows = table.findAll('tr')
       row_spans = []
       do_ident = False

       for tr in rows:
           cols = tr.findAll(['th','td'])

           for cell in cols:
               colspan = int(cell.get('colspan',1))
               rowspan = int(cell.get('rowspan',1))

               if do_ident:
                   do_ident = False
                   csv += ','*(len(row_spans))

               if rowspan > 1: row_spans.append(rowspan)

               csv += '"{text}"'.format(text=str(cell.text).strip()) + ','*(colspan)

           if row_spans:
               for i in xrange(len(row_spans)-1,-1,-1):
                   row_spans[i] -= 1
                   if row_spans[i] < 1: row_spans.pop()

           do_ident = True if row_spans else False

           csv += '\n'

       csvs.append(csv)
       #print csv

   return '\n\n'.join(csvs)

webpage = urllib2.urlopen("http://maktaba.tetea.org/exam-results/CSEE2015/p0101.htm")
content = webpage.read()
print table2csv(content)