
--Query to get the total and average values of rentals per month per year per store

SELECT store_table.store_id AS store_id, Year(payment_table.payment_date) AS per_year
,Month(payment_table.payment_date) AS per_month,
sum(payment_table.amount) AS total_value, avg(payment_table.amount) AS average_sale FROM store AS store_table 
 INNER JOIN staff as staff_table ON store_table.manager_staff_id = staff_table.staff_id
 INNER JOIN payment as payment_table on payment_table.staff_id = staff_table.staff_id 
 WHERE payment_table.payment_date <= NOW() - INTERVAL 1 year AND 
 payment_table.payment_date <= NOW() - INTERVAL 1 month
 GROUP BY store_table.store_id,Year(payment_table.payment_date), Month(payment_table.payment_date);