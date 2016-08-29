# EducationDashboardProject

### Installation
  1. Download the [2015 CSEE Data](https://drive.google.com/open?id=0ByavnGEqYLITN1BBTWpIYjlYNmc) and the [Tanzanian Secondary Schools Database - List of Schools](https://docs.google.com/a/scu.edu/spreadsheets/d/1mktIwy0yubeShQ69MG-0v7U9RnpOt4vkSiXHaPSoILI/edit?usp=sharing) as *Comma-Separated Values* ( `.csv` ) files
  2. Import the files into your MySQL-compatible database using your preferred method  
    My way:
    * Install **csvkit**
      * Linux package manager: `[apt-get | yum | dnf | etc.] install python3-csvkit`
      * Python: `pip install csvkit`
    * Run `csv-to-sql.sh` for each file you want to import
      * ex: `csv-to-sql.sh -u [your MySQL username] -d [target database] 2015_csee_data.csv`
      * It is recommended that you make a scratch database for manipulating tables into a format readable by the HighCharts map plugin
  3. Create a new database dedicated to the datasets for the chart  
    **Note:** the webpage will automatically populate the map's dataset list with an entry for every table in the database it is pointed to. Any incorrectly-formatted tables will result in junk entries.
    * Use the six included `.sql` files to generate tables out of the imported data in the scratch database
      * ex: `mysql -u [username] -p [target database] < createtable_csee2015_passrate.sql`
    * copy those tables into the new database
      * ex: ``CREATE TABLE map.`Pass Rate` SELECT * FROM data.csee2015_passrate;``

The webpage will now automatically make the data available to the map
