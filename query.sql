SELECT 
    LEFT(kode_akun_2, 2) AS kode_akun_2, 
    SUM(CASE WHEN month_year = '2024-01-01' THEN total ELSE 0 END) AS `Jan-24`,
    SUM(CASE WHEN month_year = '2024-02-01' THEN total ELSE 0 END) AS `Feb-24`,
    SUM(CASE WHEN month_year = '2023-02-01' THEN total ELSE 0 END) AS `Feb-23`
FROM excel
WHERE LEFT(kode_akun_2, 2) IN ('52', '53', '54', '55', '56')
GROUP BY LEFT(kode_akun_2, 2);




-----------------------------------------------------------------------------------------------
SELECT 
    average_revenue,
    CASE 
        WHEN average_revenue = 0 THEN 'Bla'
        WHEN average_revenue < 55000000 THEN 'Bron'
        WHEN average_revenue < 60000000 THEN 'Bron+'
        WHEN average_revenue < 100000000 THEN 'Sil'
        WHEN average_revenue < 200000000 THEN 'Gol'
        WHEN average_revenue < 400000000 THEN 'Pla'
        WHEN average_revenue > 400000000 THEN 'Dia'
    END AS category
FROM (
    SELECT 
        (revenue_m1 + revenue_m2 + revenue_m3 + 
         revenue_m4 + revenue_m5 + revenue_m6) / 6 AS average_revenue
    FROM revenue
) AS revenue_avg;

-----------------------------------------------------------------------------------------------
SELECT 
    average_availability,
    CASE 
        WHEN average_availability = 0 THEN 'Bla'
        WHEN average_availability < 90 THEN '< 90%'
        WHEN average_availability < 98 THEN '90% - 98%'
        WHEN average_availability < 100.1 THEN '98% s/d 100%'
    END AS availability_category
FROM (
    SELECT 
        (availability_m1 + availability_m2 + availability_m3 + 
         availability_m4 + availability_m5 + availability_m6) / 6 AS average_availability
    FROM revenue
) AS availability_avg;


---------------------------------------------------------------------------------------------------
SELECT 
    (revenue_m1 + revenue_m2 + revenue_m3 + 
     revenue_m4 + revenue_m5 + revenue_m6) / 6 AS average_revenue,
    CASE 
        WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
              revenue_m4 + revenue_m5 + revenue_m6) / 6 = 0 THEN 'Bla'
        WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
              revenue_m4 + revenue_m5 + revenue_m6) / 6 < 55000000 THEN 'Bron'
        WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
              revenue_m4 + revenue_m5 + revenue_m6) / 6 < 60000000 THEN 'Bron+'
        WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
              revenue_m4 + revenue_m5 + revenue_m6) / 6 < 100000000 THEN 'Sil'
        WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
              revenue_m4 + revenue_m5 + revenue_m6) / 6 < 200000000 THEN 'Gol'
        WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
              revenue_m4 + revenue_m5 + revenue_m6) / 6 < 400000000 THEN 'Pla'
        ELSE 'Dia'
    END AS revenue_category,
    
    (availability_m1 + availability_m2 + availability_m3 + 
     availability_m4 + availability_m5 + availability_m6) / 6 AS average_availability,
    CASE 
        WHEN (availability_m1 + availability_m2 + availability_m3 + 
              availability_m4 + availability_m5 + availability_m6) / 6 = 0 THEN 'Bla'
        WHEN (availability_m1 + availability_m2 + availability_m3 + 
              availability_m4 + availability_m5 + availability_m6) / 6 < 90 THEN '< 90%'
        WHEN (availability_m1 + availability_m2 + availability_m3 + 
              availability_m4 + availability_m5 + availability_m6) / 6 < 98 THEN '90% - 98%'
        WHEN (availability_m1 + availability_m2 + availability_m3 + 
              availability_m4 + availability_m5 + availability_m6) / 6 < 100.1 THEN '98% s/d 100%'
    END AS availability_category
FROM revenue;


------------------------------------------------------------------------------------------------
SELECT * 
FROM (
    SELECT 
        average_revenue,
        CASE 
            WHEN average_revenue = 0 THEN 'Bla'
            WHEN average_revenue < 55000000 THEN 'Bron'
            WHEN average_revenue < 60000000 THEN 'Bron+'
            WHEN average_revenue < 100000000 THEN 'Sil'
            WHEN average_revenue < 200000000 THEN 'Gol'
            WHEN average_revenue < 400000000 THEN 'Pla'
            ELSE 'Dia'
        END AS category
    FROM (
        SELECT 
            (COALESCE(revenue_m1, 0) + COALESCE(revenue_m2, 0) + COALESCE(revenue_m3, 0) + 
             COALESCE(revenue_m4, 0) + COALESCE(revenue_m5, 0) + COALESCE(revenue_m6, 0)) / 6 AS average_revenue
        FROM revenue
    ) AS revenue_avg
) AS categorized_revenue
WHERE category = 'Bron+';





----------------------------------------------------------------
SELECT 
    regional,
    SUM(CASE WHEN average_availability < 90 THEN 1 ELSE 0 END) AS total_P1,
    SUM(CASE WHEN average_availability BETWEEN 90 AND 98 THEN 1 ELSE 0 END) AS total_P2,
    SUM(CASE WHEN average_availability > 98 THEN 1 ELSE 0 END) AS total_Non_Program
FROM (
    SELECT 
        regional,
        (availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 AS average_availability
    FROM revenue
) AS availability_avg
GROUP BY regional;
------------------------------------------------------------------
WITH revenue_data AS (
    SELECT 
        (revenue_m1 + revenue_m2 + revenue_m3 + 
         revenue_m4 + revenue_m5 + revenue_m6) / 6 AS avg_revenue,
        (availability_m1 + availability_m2 + availability_m3 + 
         availability_m4 + availability_m5 + availability_m6) / 6 AS average_availability
    FROM revenue
)
SELECT 
    CASE 
        WHEN avg_revenue = 0 THEN 'Bla'
        WHEN avg_revenue < 55000000 THEN 'Bron'
        WHEN avg_revenue < 60000000 THEN 'Bron+'
        WHEN avg_revenue < 100000000 THEN 'Sil'
        WHEN avg_revenue < 200000000 THEN 'Gol'
        WHEN avg_revenue < 400000000 THEN 'Pla'
        ELSE 'Dia'
    END AS revenue_category,
    average_availability
FROM revenue_data
WHERE avg_revenue < 55000000; -- Sesuai dengan kategori 'Bron'
WITH revenue_data AS (
    SELECT 
        (revenue_m1 + revenue_m2 + revenue_m3 + 
         revenue_m4 + revenue_m5 + revenue_m6) / 6 AS avg_revenue,
        (availability_m1 + availability_m2 + availability_m3 + 
         availability_m4 + availability_m5 + availability_m6) / 6 AS average_availability
    FROM revenue
)
SELECT 
    CASE 
        WHEN avg_revenue = 0 THEN 'Bla'
        WHEN avg_revenue < 55000000 THEN 'Bron'
        WHEN avg_revenue < 60000000 THEN 'Bron+'
        WHEN avg_revenue < 100000000 THEN 'Sil'
        WHEN avg_revenue < 200000000 THEN 'Gol'
        WHEN avg_revenue < 400000000 THEN 'Pla'
        ELSE 'Dia'
    END AS revenue_category,
    average_availability
FROM revenue_data
WHERE avg_revenue < 55000000; -- Sesuai dengan kategori 'Bron'


------------------------------------------------------------------------------------------
SELECT * FROM (
    SELECT CASE  WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
                  revenue_m4 + revenue_m5 + revenue_m6) / 6 = 0 THEN 'Bla'
            WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
                  revenue_m4 + revenue_m5 + revenue_m6) / 6 < 55000000 THEN 'Bron'
            WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
                  revenue_m4 + revenue_m5 + revenue_m6) / 6 < 60000000 THEN 'Bron+'
            WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
                  revenue_m4 + revenue_m5 + revenue_m6) / 6 < 100000000 THEN 'Sil'
            WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
                  revenue_m4 + revenue_m5 + revenue_m6) / 6 < 200000000 THEN 'Gol'
            WHEN (revenue_m1 + revenue_m2 + revenue_m3 + 
                  revenue_m4 + revenue_m5 + revenue_m6) / 6 < 400000000 THEN 'Pla'
            ELSE 'Dia'
        END AS revenue_category,
        (availability_m1 + availability_m2 + availability_m3 + 
         availability_m4 + availability_m5 + availability_m6) / 6 AS average_availability
    FROM revenue
) AS subquery
WHERE subquery.revenue_category = 'Pla';

------------------------------------------------------------------------------------------
SELECT 
    regional,
    SUM(CASE WHEN revenue_category = 'Pla' AND avg_availability < 90 THEN 1 ELSE 0 END) AS total_P1,
    SUM(CASE WHEN revenue_category = 'Pla' AND avg_availability BETWEEN 90 AND 98 THEN 1 ELSE 0 END) AS total_P2,
    SUM(CASE WHEN revenue_category = 'Pla' AND avg_availability > 98 THEN 1 ELSE 0 END) AS total_Non_Program
FROM (
    SELECT 
        regional,
        CASE  
            WHEN avg_revenue = 0 THEN 'Bla'
            WHEN avg_revenue < 55000000 THEN 'Bron'
            WHEN avg_revenue < 60000000 THEN 'Bron+'
            WHEN avg_revenue < 100000000 THEN 'Sil'
            WHEN avg_revenue < 200000000 THEN 'Gol'
            WHEN avg_revenue < 400000000 THEN 'Pla'
            ELSE 'Dia'
        END AS revenue_category,
        avg_availability
    FROM (
        SELECT 
            regional,
            (revenue_m1 + revenue_m2 + revenue_m3 + 
             revenue_m4 + revenue_m5 + revenue_m6) / 6 AS avg_revenue,
            (availability_m1 + availability_m2 + availability_m3 + 
             availability_m4 + availability_m5 + availability_m6) / 6 AS avg_availability
        FROM revenue
    ) AS calculated_values
) AS categorized_data
WHERE revenue_category = 'Pla'
GROUP BY regional;

-------------------------------------------------------------------------------------------

SELECT  regional,
                    SUM(CASE WHEN revenue_category = '$param' AND avg_availability < 90 THEN 1 ELSE 0 END) AS total_P1,
                    SUM(CASE WHEN revenue_category = '$param' AND avg_availability BETWEEN 90 AND 98 THEN 1 ELSE 0 END) AS total_P2,
                    SUM(CASE WHEN revenue_category = '$param' AND avg_availability > 98 THEN 1 ELSE 0 END) AS total_Non_Program
                FROM (
                    SELECT regional,
                        CASE  
                            WHEN avg_revenue = 0 THEN 'Bla'
                            WHEN avg_revenue < 55000000 THEN 'Bron'
                            WHEN avg_revenue < 60000000 THEN 'Bron+'
                            WHEN avg_revenue < 100000000 THEN 'Sil'
                            WHEN avg_revenue < 200000000 THEN 'Gol'
                            WHEN avg_revenue < 400000000 THEN 'Pla'
                            ELSE 'Dia'
                        END AS revenue_category,
                        avg_availability
                    FROM (
                    SELECT   regional,
                        CASE 
                            WHEN 
                                ( (revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
                                (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0) ) = 0 
                            THEN 0
                            ELSE 
                                (revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / 
                                NULLIF( 
                                    ( (revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
                                    (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0) ), 0)
                        END AS avg_revenue,
                        
                        CASE 
                            WHEN 
                                ( (availability_m1 <> 0) + (availability_m2 <> 0) + (availability_m3 <> 0) + 
                                (availability_m4 <> 0) + (availability_m5 <> 0) + (availability_m6 <> 0) ) = 0 
                            THEN 0
                            ELSE 
                                (availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 
                                NULLIF( 
                                    ( (availability_m1 <> 0) + (availability_m2 <> 0) + (availability_m3 <> 0) + 
                                    (availability_m4 <> 0) + (availability_m5 <> 0) + (availability_m6 <> 0) ), 0)
                        END AS avg_availability
                    FROM revenue

                    ) AS calculated_values
                    
                ) AS categorized_data
                GROUP BY regional;















				--    WHEN avg_revenue = 0 THEN 'Bla'
                --             WHEN avg_revenue < 55000000 THEN 'Bron'
                --             WHEN avg_revenue < 60000000 THEN 'Bron+'
                --             WHEN avg_revenue < 100000000 THEN 'Sil'
                --             WHEN avg_revenue < 200000000 THEN 'Gol'
                --             WHEN avg_revenue < 400000000 THEN 'Pla'
                --             ELSE 'Dia'
                


				SELECT regional,
                       COUNT(CASE WHEN average_availability < 89.9 THEN 1 END) AS total_P1, 
                       COUNT(CASE WHEN average_availability BETWEEN 98 AND 100 THEN 1 END) AS sales_P1, 
                       COUNT(CASE WHEN average_availability < 89.9 THEN 1 END) AS non_program_sales, 
                       COUNT(CASE WHEN average_availability BETWEEN 90 AND 97.99 THEN 1 END) AS total_P2, 
                       COUNT(CASE WHEN average_availability >= 98 THEN 1 END) AS total_Non_Program ,
                       (SELECT site_id FROM revenue WHERE average_availability < 89.9) AS data_P1,
                       (SELECT site_id FROM revenue WHERE average_availability  98 AND 100) AS data_sales_P1,
                       (SELECT site_id FROM revenue WHERE average_availability < 89.9) AS data_non_program_sales,
                       (SELECT site_id FROM revenue WHERE average_availability BETWEEN 90 AND 97.99) AS data_non_program_sales,
                       (SELECT site_id FROM revenue WHERE average_availability >= 98) AS data_non_program_sales,
  
                             CAST((availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 					AS FLOAT)
                            AS average_availability  
                        FROM revenue AS availability_avg 
               	WHERE avg_revenue BETWEEN 59999999 AND 99999999
                GROUP BY regional
                order by regional DESC;


-----------------------------------------------------------------------------------------------------------------------------------------
SELECT * FROM revenue WHERE site_id 
IN (SELECT site_id FROM (
        SELECT site_id, 
            CASE 
                WHEN ((revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
                      (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0)) = 0 
                THEN 0 
                ELSE (revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / 
                     NULLIF(((revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
                             (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0)), 0) 
            END AS avg_revenue,
    	   CAST((availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 AS FLOAT)
 			AS average_availability 
        FROM revenue
    ) AS revenue_avg
    WHERE avg_revenue BETWEEN 99999999 AND 199999999
    AND average_availability >= 98
);








               