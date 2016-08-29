DROP TABLE IF EXISTS csee2015_top3div_boys;
CREATE TABLE csee2015_top3div_boys AS
SELECT
	hc_key AS 'hc-key',
	top3div/total AS 'value'
FROM
(
	(
		SELECT
			region,
			COUNT( CASE WHEN ((division='I' OR division='II' OR division='III') AND gender='M') THEN 1 END ) 'top3div',
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
