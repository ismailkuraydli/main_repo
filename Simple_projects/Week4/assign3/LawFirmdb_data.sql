USE LawFirmdb;
--
-- Dumping data for table Claims
--
INSERT INTO Claims VALUES 
(1,'Bassem Dghaidi'),
(2,'Omar Breidi'),
(3,'Marwan Sawwan');
--
-- Dumping data for table Defendants
--
INSERT INTO Defendants VALUES
 (1,'Jean Skaff'),
(1,'Elie Meouchi'),
(1,'Radwan Sameh'),
(2,'Joseph Eid'),
(2,'Paul Syoufi'),
(2,'Radwan Sameh'),
(3,'Issam Awwad');
--
-- Dumping data for table ClaimStatusCodes
--
INSERT INTO ClaimStatusCodes VALUES
('AP','Awaiting review panel',1),
('OR','Panel opinion rendered',2),
('SF','Suit files',3),
('CL','Closed',4);
--
-- Dumping data for table LegalEvents
--
INSERT INTO LegalEvents VALUES 
(1,'Jean Skaff','AP','20160101'),
(1,'Jean Skaff','OR','20160202'),
(1,'Jean Skaff','SF','20160301'),
(1,'Jean Skaff','CL','20160401'),
(1,'Radwan Sameh','AP','20160101'),
(1,'Radwan Sameh','OR','20160202'),
(1,'Radwan Sameh','SF','20160301'),
(1,'Elie Meouchi','AP','20160101'),
(1,'Elie Meouchi','OR','20160202'),
(2,'Radwan Sameh','AP','20160101'),
(2,'Radwan Sameh','OR','20160201'),
(2,'Paul Syoufi','AP','20160101'),
(3,'Issam Awwad','AP','20160101');

