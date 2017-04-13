#!/usr/bin/env python
"""

"""
from __future__ import print_function
import sys
import os.path
import urllib2
import re
from bs4 import BeautifulSoup

def table2csv(html, name):
    """
    Scrapes an HTML document and prints the contents of
    enclosed tables formatted as CSV.
    
    An extra column containing 'name' with the extension
    stripped is prepended to the resulting table.

    Returns nothing, prints the resulting CSV to stdout.

    :param html: string containing webpage html
    :param name: string containing webpage filename
    """
    name = os.path.splitext(name)[0]    # remove the extension from the filename
    name = name.replace(' ', '')        # remove spaces from the filename
    soup = BeautifulSoup(html, 'lxml')  # fetch the webpage
    table = soup.find('table')          # find the first table
    rows = table.findAll('tr')          # find all <tr> tags (rows)

    for row in rows[1:]:                        # print all but the first row to avoid duplicate column headings
        cells = row.findAll('td')               # find all <td> (data) tags
        print('"{}"'.format(name), end='')      # print the NECTA ID
        for cell in cells:
            print(',"{}"'.format(cell.find('p').string.strip()), end='')    # print everything else
        print()                                 # print a newline

# check arguments
if __name__ == '__main__':
    if len(sys.argv) != 2:
        print('Usage: ./scraper.py [directory]')
        sys.exit(1)

    # filenames to ignore
    ignore = ['p0001.html', 'Parent Directory'
    ]

    directory = urllib2.urlopen(sys.argv[1])
    dircontent = directory.read()
    dirsoup = BeautifulSoup(dircontent, 'lxml')
    years = dirsoup.findAll('li')
    for year in years:
        name = year.find('a').string.strip()
        if re.search('^[p|s|P|S]\d{4}', name) and name not in ignore:
            webpage = urllib2.urlopen(sys.argv[1] + name.replace(' ', '%20'))   # replace spaces with the URL escape sequence
            content = webpage.read()
            table2csv(content, name)
