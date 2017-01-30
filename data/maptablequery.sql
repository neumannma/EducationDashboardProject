CREATE TABLE map.`2008`
SELECT
	hc_key AS 'hc-key',
	ownership,
	gender,
	division
FROM MASTER JOIN `2008`
WHERE `2008`.necta = MASTER.necta
;
