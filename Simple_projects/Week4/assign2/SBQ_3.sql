--Query to get the top 3 countries where customers are originating
SELECT  country_table.country_id as countryid, country_table.country,
 COUNT(country_table.country_id) AS number_of_customers 
FROM customer as customers, address as address_table, city as c, country as country_table 
WHERE customers.address_id = address_table.address_id 
AND address_table.city_id = c.city_id 
AND c.country_id = country_table.country_id 
GROUP BY country_table.country_id 
ORDER BY count(country_table.country_id) DESC 
LIMIT 3;