--
-- Query to find the the current claim status for every claim
--
SELECT 
    final_table.cl_id, final_table.pa_name, codes.claim_status
FROM
    (SELECT 
        max_status.claim_id AS cl_id,
            claims_table.patient_name AS pa_name,
            MIN(max_status_def) AS cl_status
    FROM
        (SELECT 
        events.claim_id,
            events.defendant_name,
            MAX(seq_codes.claim_seq) AS max_status_def
    FROM
        LegalEvents AS events
    INNER JOIN ClaimStatusCodes AS seq_codes ON events.claim_status = seq_codes.claim_status
    GROUP BY events.claim_id , events.defendant_name) AS max_status
    INNER JOIN Claims AS claims_table ON max_status.claim_id = claims_table.claim_id
    GROUP BY max_status.claim_id) AS final_table
        INNER JOIN
    ClaimStatusCodes AS codes ON final_table.cl_status = codes.claim_seq
ORDER BY final_table.cl_id;

