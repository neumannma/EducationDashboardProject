#!/bin/bash

# # #
# csv2db.sh
#
# Used to automate the process of importing a .csv file into a MySQL table
#
# Dependencies:
#	- csvkit (apt-get install python3-csvkit OR pip install csvkit)
#	- A MySQL compatible database shell
# # #

# variables
scriptname_default="maketable.sql"
database="data"
username="remote"

# check if an in-file was specified
if [ -z $1 ]; then
	echo "Usage: $0 [in-data.csv] [out-script.sql (default: maketable.sql)]"
	exit 1
fi

# if the optional out-file name was not specified, use the default
if [ -z $2 ]; then
	scriptname=$scriptname_default
else
	scriptname=$2
fi

# generate the SQL script to create the table
csvsql --dialect mysql --snifflimit 100000 $1 > $scriptname

# append the SQL query to import the CSV data
tablename=$1
echo "LOAD DATA LOCAL INFILE '$PWD/$1' INTO TABLE ${tablename:0:-4}" >> $scriptname
echo "FIELDS TERMINATED BY ','" >> $scriptname
echo "ENCLOSED BY '\"'" >> $scriptname
echo "LINES TERMINATED BY '\n';" >> $scriptname

# run the SQL script
mysql -u $username -p $database < $scriptname
