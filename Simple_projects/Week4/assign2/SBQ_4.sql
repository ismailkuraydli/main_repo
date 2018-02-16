
--Return all second addresses sorted

UPDATE address SET address2 = address WHERE address_id > 3 AND address_id <50;

--sort by address string

SELECT  address_id, address2 FROM address WHERE address2 IS NOT NULL AND address2 <> '' ORDER BY address2;

-- sort by id


SELECT  address_id, address2 FROM address WHERE address2 IS NOT NULL AND address2 <> '' ORDER BY address_id;


