CREATE TABLE map.`2016`
SELECT
	hc_key AS 'hc-key',
	ownership,
	gender,
	division
FROM MASTER JOIN `2016`
WHERE `2016`.necta = MASTER.necta
;
