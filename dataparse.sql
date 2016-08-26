/*	delete the first row of the table,
	assuming it contains the column names */
/*WITH target AS
SELECT TOP 1 * FROM 2015_csee_data_by_school
DELETE FROM target;*/
DELETE TOP(1) FROM 2015_csee_data_by_school; /* doesn't work */

/* aggregate data from 2015_csee_data_by_school into region, # pass, and # total */
SELECT region, ( SUM(DI) + SUM(DII) + SUM(DIII) + SUM(`DIV`) ) AS 'pass', ( SUM(DI) + SUM(DII) + SUM(DIII) + SUM(`DIV`) + SUM(`0`) + SUM(`ABS`) ) AS 'total'
FROM 2015_csee_data_by_school
GROUP BY region;

/* aggregate data from 2015_csee_data_by_school into region, % pass / total */
SELECT region, (( SUM(DI) + SUM(DII) + SUM(DIII) + SUM(`DIV`) ) / ( SUM(DI) + SUM(DII) + SUM(DIII) + SUM(`DIV`) + SUM(`0`) + SUM(`ABS`) )) AS 'pass'
FROM 2015_csee_data_by_school
GROUP BY region;

/* create from 2015_csee_data_by_school into hc-key, %pass/total */
CREATE TABLE csee2015_passrate AS
SELECT hc_key AS 'hc-key', pass AS 'value'
FROM
(
	(
		SELECT region, (( SUM(DI) + SUM(DII) + SUM(DIII) + SUM(`DIV`) ) / ( SUM(DI) + SUM(DII) + SUM(DIII) + SUM(`DIV`) + SUM(`0`) + SUM(`ABS`) )) AS 'pass'
		FROM 2015_csee_data_by_school
		GROUP BY region
	) aggregate1
	JOIN RegionCodes ON RegionCodes.region=aggregate1.region
);
