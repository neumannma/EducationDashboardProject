CREATE TABLE map.2003
SELECT
	hc_key AS 'hc-key',
	MASTER.necta,
	ownership,
	gender,
	division
FROM MASTER JOIN `2003`
WHERE `2003`.necta = MASTER.necta
;
