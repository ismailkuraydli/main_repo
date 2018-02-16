/*
Query to find all the film categories in which there are between 55 and 65 films. 
Return the names of thesecategories and the number of films per category, sorted by the number of films.
If there are no categories
between 55 and 65, return the highest available counts.
*/
CREATE VIEW genre_film_count 
AS SELECT * FROM (
    SELECT cat.name AS genre_name, COUNT(fc.film_id) AS count_of_films 
FROM category as cat , film_category as fc 
WHERE cat.category_id = fc.category_id 
GROUP BY cat.name ORDER BY COUNT(fc.film_id)
) AS genre_film_count;

SELECT * FROM genre_film_count WHERE count_of_films BETWEEN 55 AND 65

UNION

SELECT * FROM genre_film_count 
WHERE count_of_films > 0 AND NOT EXISTS (
    SELECT 1 FROM genre_film_count WHERE count_of_films BETWEEN 55 AND 65) ORDER BY count_of_films DESC;


