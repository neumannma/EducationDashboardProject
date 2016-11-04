#!/bin/bash

# # #
# csv-to-sql.sh
#
# Used to automate the process of importing a .csv file into a MySQL table
#
# Dependencies:
#	- csvkit (apt-get install python3-csvkit OR pip install csvkit)
#	- A MySQL compatible database shell
# # #

# USER CONFIGURABLE
username="remote"   # default username
database="data"     # default database name

# configure environment
set -e	# exit on nonzero return value from command

# variables
scriptname="maketable.sql"
force=false

# functions
cleanup() { rm $scriptname; }
trap cleanup EXIT

usage() { echo "Usage: $0 [-f (force table creation, overwrites existing table)] [-u username] [-d database] csv_file"; }

# parse tagged args
while getopts ":fu:d:" opts; do
	case "${opts}" in
		f)
			force=true
			;;
		u)
			username=${OPTARG}
			;;
		d)
			database=${OPTARG}
			;;
		*)
			usage
			exit 1
			;;
	esac
done

# parse remaining args
shift $(($OPTIND - 1))
if [ -z $1 ]; then
	usage
	exit 1
fi
infile=$1
tablename=${infile:0:-4}

# generate the SQL script to create the table
if $force; then
	echo "DROP TABLE IF EXISTS \`$tablename\`;" > $scriptname
fi
csvsql --dialect mysql --snifflimit 100000 -d "," $infile >> $scriptname

# append the SQL query to import the CSV data
echo "LOAD DATA LOCAL INFILE '$PWD/$1' INTO TABLE \`$tablename\`" >> $scriptname
echo "FIELDS TERMINATED BY ','" >> $scriptname
echo "ENCLOSED BY '\"'" >> $scriptname
echo "LINES TERMINATED BY '\n';" >> $scriptname

# run the SQL script
mysql -u $username -p $database < $scriptname
echo "Table '$tablename' created in database '$database' by user '$username'."