--Query to get the top three languages released in 2006

--Change some language id values to test the query since all are english in this test set
UPDATE film SET language_id = 2 WHERE film_id > 4 AND film_id < 40;
UPDATE film SET language_id = 3 WHERE film_id > 40 AND film_id < 50;
UPDATE film SET language_id = 4 WHERE film_id > 50 AND film_id < 150;
UPDATE film SET language_id = 5 WHERE film_id > 150 AND film_id < 200;
UPDATE film SET language_id = 6 WHERE film_id > 200 AND film_id < 400;
UPDATE film SET language_id = 3 WHERE film_id > 500 AND film_id < 550;
UPDATE film SET language_id = 2 WHERE film_id > 550 AND film_id < 600;

SELECT film_table.language_id AS language_id, languade_desc.name AS language, COUNT(film_table.film_id) 
FROM film AS film_table 
INNER JOIN language as languade_desc on film_table.language_id = languade_desc.language_id
WHERE film_table.release_year = '2006' 
GROUP BY film_table.language_id 
ORDER BY COUNT(film_table.film_id) DESC limit 3;