/* Query to return the first and last names of actors
 who played in a film involving a “Crocodile” and a “Shark”, along
with the release year of the movie, sorted by the actors’ last names*/
SELECT a.first_name, a.last_name, f.release_year FROM actor as a 
INNER JOIN film_actor as fa on fa.actor_id = a.actor_id INNER JOIN film as f on f.film_id = fa.film_id
 WHERE f.description LIKE '%Shark%' AND description like '%crocodile%' ORDER BY a.last_name;