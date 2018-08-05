# EducationDashboardProject

### TODO
  * Update this readme
  * scraper.py
    * handle timeout
    * handle invalid data exceptions
      * throw out the school & print a warning
    * auto generate column labels
    * more flexibility (e.g. scrape a single school from a given year at a time)
  * barchart / map
    * make shared folder for common stylesheet assets
    * add loading spinners
  * barchart
    * finish mobile UI
    * add message when school not found

### Installation
  1. Clone the repository
    * Place the `/webpage` directory into the HTTP server directory
      * Apache default: `/var/www/html/`
    * The remaining materials can be used from anywhere
  2. Create the database
    * Add a new database: `[database]`
    * Add a new MySQL user, for use by the scripts: `[username]`
      * Grant it read access to `[database]`
    * Modify `/webpage/resources/config.ini` with the credentials for `[username]`
  3. Popuate the database
    * Using `dump.sql`:
      * `mysql [database] -u [username] -p < dump.sql`
    * **Alternatively**, provide custom data (see [Import Data from CSV](#import-data-from-csv))
    * Note: the webpage will treat tables in `[database]` as map data, any ill-formed tables will result in page errors

### Files
  * `dump.sql`
    * SQL script to add map data tables to a database
  * `csv-to-sql.sh`
    * Bash script to create SQL tables from CSV files
  * `/webpage`
    * `index.php`
      * main page HTML
      * PHP script to fetch table names from database and populate select menu
    * `style.css`
      * Formatting for `index.php` so it renders correctly
    * `query.php`
      * PHP script to fetch data from table based on value of select menu in `index.php` and serve it to `client.js`
    * `client.js`
      * Render the map using the Highcharts Highmaps framework
      * Detect and handle viewport resizes
    * `/resources`
      * `config.ini`
        * Should be made unaccessible via HTTP
        * Stores credentials for PHP script database connections
      * `.htaccess`
        * Instructs Apache HTTP Server to deny access to the `/webpage/resources` directory
        * Must set `AllowOverride All` for the webpage directory in `httpd.conf`
        * **Alternatively**, copy the following into `httpd.conf`:
        ```
        <directory "/var/www/html/webpage/resources">
          Deny from all
        </directory>
        ```

### Import Data from CSV
  1. Install csvkit
    * Linux:  `[apt-get | yum | dnf | ... ] install python3-csvkit`
    * Python: `pip install csvkit`
  2. Run `csv-to-sql.sh` on each file to be imported
    * `csv-to-sql.sh -u [username] -d [database] data.csv`
    * Note: add the `-f` flag to overwrite existing tables in the event of a name collision
