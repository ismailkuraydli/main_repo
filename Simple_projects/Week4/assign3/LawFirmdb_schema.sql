DROP DATABASE IF EXISTS LawFirmdb;
CREATE DATABASE LawFirmdb;
USE LawFirmdb;
--
-- Table structure for table `Claims`
--
CREATE TABLE Claims (
    claim_id INT NOT NULL,
    patient_name VARCHAR(30) NOT NULL,
    PRIMARY KEY (claim_id)
);
--
-- Table structure for table `Defendants`
--
CREATE TABLE Defendants (
    claim_id INT NOT NULL,
    defendant_name VARCHAR(30) NOT NULL,
    FOREIGN KEY (claim_id)
        REFERENCES Claims (claim_id)
);
--
-- Table structure for table `ClaimStatusCodes`
--
CREATE TABLE ClaimStatusCodes (
    claim_status VARCHAR(2) NOT NULL UNIQUE,
    claim_status_desc VARCHAR(50),
    claim_seq INT NOT NULL,
    PRIMARY KEY (claim_seq , claim_status)
);
--
-- Table structure for table `LegalEvents`
--
CREATE TABLE LegalEvents (
    claim_id INT NOT NULL,
    defendant_name VARCHAR(30) NOT NULL,
    claim_status VARCHAR(2) NOT NULL,
    change_date DATE,
    FOREIGN KEY (claim_id)
        REFERENCES Claims (claim_id),
    FOREIGN KEY (claim_status)
        REFERENCES ClaimStatusCodes (claim_status)
);