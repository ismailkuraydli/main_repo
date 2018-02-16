
--Query to return the top three customers who rented the most movies per yea

SELECT * FROM (

SELECT (@row:=if(@prev=b.year, @row +1, if(@prev:= b.year, 1, 1))) as customer_rank , b.* FROM(

    SELECT rental_table.customer_id AS customer_id, YEAR(rental_table.rental_date) as year,
     COUNT(rental_table.rental_id) as count 
        FROM rental as rental_table WHERE rental_table.rental_date <= NOW() - interval 1 YEAR 
        group by rental_table.customer_id, YEAR(rental_table.rental_date)
        ORDER BY YEAR(rental_table.rental_date),COUNT(rental_table.rental_id) DESC
) AS b CROSS JOIN (select @row:=0, @prev:=null) c 

) as src where src.customer_rank <=3;