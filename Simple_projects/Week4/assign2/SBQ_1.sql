
--Query to get the total number of movies per actor

SELECT f_actor.actor_id AS id,actor_names.first_name as first_name,
actor_names.last_name as last_name, COUNT(f_actor.film_id) AS number_of_films
FROM film_actor as f_actor 
INNER JOIN actor as actor_names on f_actor.actor_id = actor_names.actor_id 
GROUP BY f_actor.actor_id;
