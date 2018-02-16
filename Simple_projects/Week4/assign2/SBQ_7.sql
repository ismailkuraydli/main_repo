--Query to find all the actors and customers with the same name as the actor with id = 8
SELECT main_table.first_name, main_table.last_name 
FROM actor AS main_table , actor as compare_table 
WHERE compare_table.actor_id = 8 AND 
compare_table.first_name = main_table.first_name AND
 main_table.actor_id <> 8
UNION ALL
SELECT main_table.first_name, main_table.last_name 
FROM customer AS main_table , actor as compare_table 
WHERE compare_table.actor_id = 8 AND compare_table.first_name = main_table.first_name;