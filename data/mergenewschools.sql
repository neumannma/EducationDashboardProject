-- delete existing entries from MASTER
DELETE newschools FROM MASTER JOIN newschools ON MASTER.necta = newschools.necta;

-- insert all entries from newschools into MASTER
INSERT INTO MASTER SELECT necta, name, ownership, region, hc_key FROM newschools;
