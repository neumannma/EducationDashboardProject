#!/usr/bin/env python
# -- coding: utf-8 --

# TODO:
#   automatically generate the column labels
#   handle timeout exceptions
#       - if webpage [p|s]XXXX.html fails to respond, keep retrying
#   handle invalid data exceptions
#       - if a particular row in a school fails, throw out the entire set for the school, print a message, and keep scraping
#   modularity
#       - function to scrape a single school from a single year

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
    # dict of unicode characters to be replaced (all others will be stripped)
    replacements = {u"’": "'", }

    # parse the NECTA ID from the filename
    name = os.path.splitext(name)[0]    # remove the extension from the filename
    name = name.replace(' ', '')        # remove spaces from the filename

    # parse the set of all rows in the table
    soup = BeautifulSoup(html, 'lxml')  # fetch the webpage
    table = soup.find('table')          # find the first table
    rows = table.findAll('tr')          # find all <tr> tags (rows)

    # iteratively format and print the 
    for row in rows[1:]:                        # print all but the first row to avoid duplicate column headings
        cells = row.findAll('td')               # find all <td> (data) tags
        print('"{}"'.format(name), end='')      # print the NECTA ID
        for cell in cells:
            text = cell.find('p').string.strip()    # strip leading and trailing whitespace
            text = text.replace(u"’", "'")          # replace unicode single quote with ASCII equivalent
            text = text.encode('ascii', 'ignore').decode('ascii')   # strip any remaining unicode characters
            print(',"{}"'.format(text), end='')     # print everything
        print()                                 # print a newline

# check arguments
if __name__ == '__main__':

    # check that the user provided an argument
    if len(sys.argv) != 2:
        print('Usage: ./scraper.py [directory]')
        sys.exit(1)

    # parse directory path (i.e. remove 'index.html' or 'olevel.html' from the path)
    directory = sys.argv[1].rsplit('/', 1)[0] + '/'

    # filenames to ignore
    ignore = ['p0001.html']

    cells = BeautifulSoup(urllib2.urlopen(sys.argv[1]), 'lxml').findAll('td')   # parse all table cells
    for cell in cells:
        anchor = cell.find('a')                                                 # parse all anchor tags in cells
        if anchor == None:                                                      # do nothing if the cell has no anchor tag
            continue
        if not anchor.has_attr('href'):
            continue
        
        # get the text from the anchor
        href = anchor['href'].strip()
        href = href.split('./')
        if len(href) == 2:
            name = href[1]
        else:
            name = href[0]
            
        if re.search('^[p|s|P|S]\d{4}', name) and name not in ignore:           # execute if the text is formatted as a NECTA ID
            webpage = urllib2.urlopen(directory + name.replace(' ', '%20'))   # replace spaces with the URL escape sequence
            content = webpage.read()
            table2csv(content, name)
