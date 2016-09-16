CREATE TABLE `2015` AS
SELECT
    `hc_key` AS 'hc-key',
    `SEX` AS 'gender',
    `DIV` AS 'division'
FROM
    newdata.`2015` JOIN newdata.SchoolsToRegion
    ON newdata.`2015`.center_id = newdata.SchoolsToRegion.necta
;