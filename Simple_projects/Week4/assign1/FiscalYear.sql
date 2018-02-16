DELIMITER $$
--Create the Database
DROP IF EXISTS DATABASE FinanceDB$$
CREATE DATABASE FinanceDB$$
USE FinanceDB

--Create the table with fiscal_year as primary key
CREATE TABLE FiscalYearTable (
    fiscal_year YEAR NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    PRIMARY KEY (fiscal_year)
)$$

/*Trigger on insert to make sure Date ranges dont overlap with othe fiscal years 
and that fiscal year is part of the range*/
CREATE TRIGGER check_fiscal_insert BEFORE INSERT ON FiscalYearTable 
FOR EACH ROW 
BEGIN
    
 IF (SELECT 1 FROM FiscalYearTable WHERE NEW.start_date BETWEEN start_date AND end_date) OR
    (SELECT 1 FROM FiscalYearTable WHERE NEW.end_date BETWEEN start_date AND end_date) THEN
    SIGNAL sqlstate '45001' set message_text = "There is an overlap with another Fiscal Year in table";
    END IF;
    
IF NEW.fiscal_year != YEAR(NEW.start_date) AND
    NEW.fiscal_year != YEAR(NEW.end_date) THEN
    SIGNAL sqlstate '45001' set message_text = "Fiscal Year must be in the range of dates";
    END IF;

END;$$

/*Trigger on update to make sure Date ranges dont overlap with othe fiscal years 
and that fiscal year is part of the range*/

CREATE TRIGGER check_fiscal_update BEFORE UPDATE ON FiscalYearTable 
FOR EACH ROW 
BEGIN
    
 IF (SELECT 1 FROM FiscalYearTable WHERE NEW.start_date BETWEEN start_date AND end_date) OR
    (SELECT 1 FROM FiscalYearTable WHERE NEW.end_date BETWEEN start_date AND end_date) THEN
    SIGNAL sqlstate '45001' set message_text = "There is an overlap with another Fiscal Year in table";
    END IF;
    
IF NEW.fiscal_year != YEAR(NEW.start_date) AND
    NEW.fiscal_year != YEAR(NEW.end_date) THEN
    SIGNAL sqlstate '45001' set message_text = "Fiscal Year must be in the range of dates";
    END IF;

END;$$

--examples and lookup query

INSERT INTO FiscalYearTable VALUES('2010','20090901','20101031')$$
INSERT INTO FiscalYearTable VALUES('2010','20090901','20091031')$$
INSERT INTO FiscalYearTable VALUES('2010','20091001','20100930')$$
INSERT INTO FiscalYearTable VALUES('1988','19881001','19890830')$$

SELECT FT.fiscal_year
FROM `FinanceDB`.`FiscalYearTable` as FT
WHERE '20091124' BETWEEN FT.start_date AND FT.end_date$$

DELIMITER ;