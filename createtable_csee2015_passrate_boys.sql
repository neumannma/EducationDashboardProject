DROP TABLE IF EXISTS csee2015_passrate_boys;
CREATE TABLE csee2015_passrate_boys AS
SELECT
	hc_key AS 'hc-key',
	pass/total AS 'value'
FROM
(
	(
		SELECT
			region,
			COUNT( CASE WHEN ((division='I' OR division='II' OR division='III' OR division='IV') AND gender='M') THEN 1 END ) 'pass',
			COUNT( CASE WHEN gender='M' THEN 1 END ) 'total'
		FROM
		(
			SELECT
				list_of_schools.REGION AS 'region',
				2015_csee_data.class AS 'division',
				2015_csee_data.gender AS 'gender'
			FROM
				list_of_schools
				JOIN 2015_csee_data
				ON list_of_schools.NECTA=2015_csee_data.center_id
		) t1
		GROUP BY region
	) data
	JOIN RegionCodes
	ON RegionCodes.region=data.region
);
