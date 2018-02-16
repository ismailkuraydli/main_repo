DROP DATABASE HospitalRecords;
CREATE DATABASE HospitalRecords;
USE HospitalRecords
CREATE TABLE AnestProcedures (
    proc_id INT NOT NULL AUTO_INCREMENT,
    anest_name VARCHAR(10) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    PRIMARY KEY (proc_id) 
);
INSERT INTO AnestProcedures VALUES (NULL,"Albert","08:00:00","11:00:00");
INSERT INTO AnestProcedures VALUES (NULL,"Albert","09:00:00","13:00:00");
INSERT INTO AnestProcedures VALUES (NULL,"Kamal","08:00:00","13:30:00");
INSERT INTO AnestProcedures VALUES (NULL,"Kamal","09:00:00","15:30:00");
INSERT INTO AnestProcedures VALUES (NULL,"Kamal","10:00:00","11:30:00");
INSERT INTO AnestProcedures VALUES (NULL,"Kamal","12:30:00","13:30:00");
INSERT INTO AnestProcedures VALUES (NULL,"Kamal","13:30:00","14:30:00");
INSERT INTO AnestProcedures VALUES (NULL,"Kamal","18:30:00","19:00:00");
Select * FROM AnestProcedures;

DELIMITER $$
CREATE PROCEDURE update_payroll ()
BEGIN 
CREATE VIEW view_count_overlaps (id_1,id_2,total)
AS SELECT a.proc_id,b.proc_id,COUNT(*)
    FROM AnestProcedures AS a,AnestProcedures AS b, AnestProcedures AS c
    WHERE b.anest_name = a.anest_name
    AND c.anest_name = a.anest_name
    AND a.start_time <= b.start_time
    AND b.start_time < a.end_time
    AND c.start_time <= b.start_time
    AND b.start_time < c.end_time
    GROUP BY a.proc_id,b.proc_id;

CREATE TABLE PayRollAnest
SELECT id_1 AS proc_id, MAX(total) AS max_inst_count
    FROM view_count_overlaps
    GROUP BY id_1;
END;$$
DELIMITER ;

CALL update_payroll;
SELECT * FROM PayRollAnest;