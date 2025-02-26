<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class RevenueModel extends Model
{
    protected $table      = 'revenue';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'site_id',
        'site_label',
        'regional',
        'revenue_m1',
        'revenue_m2',
        'revenue_m3',
        'revenue_m4',
        'revenue_m5',
        'revenue_m6',
        'availability_m1',
        'availability_m2',
        'availability_m3',
        'availability_m4',
        'availability_m5',
        'availability_m6',
        'created_at',
        'updated_at',
    ];



    public function getDataTables($request)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, kode_dokumen, kategori_dokumen, kode_akun_1, kode_akun_2'); // Adjust fields as needed
        $builder->where('is_deleted', 0);

        // Searching
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $builder->groupStart();
            foreach ($this->column_search as $column) {
                $builder->orLike($column, $searchValue);
            }
            $builder->groupEnd();
        }

        // Ordering
        if (isset($request['order'])) {
            $orderColumn = $this->column_order[$request['order'][0]['column']];
            $orderDir = $request['order'][0]['dir'];
            $builder->orderBy($orderColumn, $orderDir);
        } else if ($this->order) {
            $key = key($this->order);
            $builder->orderBy($key, $this->order[$key]);
        }

        // Pagination
        if ($request['length'] != -1) {
            $builder->limit($request['length'], $request['start']);
        }

        return $builder->get()->getResult();
    }

    public function countFiltered($request)
    {
        $builder = $this->db->table($this->table);
        $builder->where('is_deleted', 0);

        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $builder->groupStart();
            foreach ($this->column_search as $column) {
                $builder->orLike($column, $searchValue);
            }
            $builder->groupEnd();
        }
        return $builder->countAllResults();
    }

    public function countAllData()
    {
        return $this->db->table($this->table)->where('is_deleted', 0)->countAllResults();
    }


    public function getAccountData($param)
    {
        $db = \Config\Database::connect();
        $cond = '';
        switch ($param) {
            case 'Bla':
                $cond = 'WHERE avg_revenue = 0 ';
                break;
            case 'Bron':
                // $cond = ' BETWEEN 0 AND 55000000 ';
                $cond = 'WHERE avg_revenue BETWEEN 1 AND 54999999 ';
                break;
            case 'Bron+':
                // $cond = ' BETWEEN 55000000 AND 60000000 ';
                // $cond = 'WHERE avg_revenue BETWEEN 55000000 AND 59999999 ';
                $cond = 'WHERE avg_revenue BETWEEN 54999999 AND 59999999 ';
                break;
            case 'Sil':
                // $cond = ' BETWEEN 60000000 AND 100000000 ';59999999
                // $cond = 'WHERE avg_revenue BETWEEN 60000000 AND 99999999 ';
                $cond = 'WHERE avg_revenue BETWEEN 59999999 AND 99999999 ';
                break;
            case 'Gol':
                // $cond = ' BETWEEN 100000000 AND 200000000 99999999';
                // $cond = 'WHERE avg_revenue BETWEEN 100000000 AND 199999999 ';
                $cond = 'WHERE avg_revenue BETWEEN 99999999 AND 199999999 ';
                break;
            case 'Pla':
                // $cond = ' BETWEEN 200000000 AND 400000000 ';
                // $cond = 'WHERE avg_revenue BETWEEN 200000000 AND 399999999 ';199999999
                $cond = 'WHERE avg_revenue BETWEEN 199999999 AND 399999999 ';
                break;
            case 'Dia':
                // $cond = 'WHERE avg_revenue > 400000000 ';
                $cond = 'WHERE avg_revenue > 399999999 ';
                break;
            default:
                $cond = '';
                break;
        }
        $sql = "SELECT regional,
                    --    COUNT(CASE WHEN average_availability < 89.9 THEN 1 END) AS total_P1, 
                    --    COUNT(CASE WHEN average_availability BETWEEN 98 AND 100 THEN 1 END) AS sales_P1, 
                    --    COUNT(CASE WHEN average_availability < 89.9 THEN 1 END) AS non_program_sales, 
                    --    COUNT(CASE WHEN average_availability BETWEEN 90 AND 97.99 THEN 1 END) AS total_P2, 
                    --    COUNT(CASE WHEN average_availability >= 98 THEN 1 END) AS total_Non_Program  
                       COUNT(CASE WHEN average_availability < 0.899 THEN 1 END) AS total_P1, 
                       COUNT(CASE WHEN average_availability BETWEEN 0.98 AND 1 THEN 1 END) AS sales_P1, 
                       COUNT(CASE WHEN average_availability < 0.899 THEN 1 END) AS non_program_sales, 
                       COUNT(CASE WHEN average_availability BETWEEN 0.90 AND 0.9799 THEN 1 END) AS total_P2, 
                       COUNT(CASE WHEN average_availability >= 0.98 THEN 1 END) AS total_Non_Program  

                    -- COUNT(IF( average_availability < 90, 1, NULL)) AS total_P1, 
                    -- COUNT(IF( average_availability BETWEEN 98 AND 100, 1, NULL)) AS sales_P1, 
                    -- COUNT(IF( average_availability < 90 AND average_availability > 98, 1, NULL)) AS non_program_sales, 
                    -- COUNT(IF( average_availability BETWEEN 90 AND 98, 1, NULL)) AS total_P2, 
                    -- COUNT(IF( average_availability > 98, 1, NULL)) AS total_Non_Program 
                    FROM (SELECT regional, revenue_m1, CASE WHEN (
                            (revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0)) = 0
                             THEN 0 
                        ELSE (revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / NULLIF(
                            ((revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0)), 
                            0) END AS avg_revenue,
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
                             END AS average_availability
                           --  CAST((availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 AS FLOAT)
                           -- AS average_availability  
                        FROM revenue) AS availability_avg 
                -- WHERE avg_revenue $cond
                $cond
                -- WHERE revenue_category = $param 
                GROUP BY regional
                order by regional DESC; ";
        // --              COUNT(IF(  avg_availability < 90, 1, NULL)) AS total_P1a,
        // -- COUNT(IF(  avg_availability BETWEEN 90 AND 98, 1, NULL)) AS total_P2a,
        // -- COUNT(IF(  avg_availability > 98, 1, NULL)) AS total_Non_Program,
        //   COUNT(CASE WHEN average_availability < 90 THEN 1 END) AS completed_orders, -- Pesanan yang selesai
        //             -- WHERE revenue_category = 'Pla'

        $query = $db->query($sql);
        $results = $query->getResult();

        // echo '<pre>';
        // var_dump($results);
        // exit;
        return $results;
    }
    public function getAllData()
    {
        $db = \Config\Database::connect();

        $sql = "SELECT  regional, 
                    COUNT(CASE WHEN avg_revenue = 0 THEN 1 END) AS Bla,
                    COUNT(CASE WHEN avg_revenue BETWEEN 1 AND 54999999 THEN 1 END) AS Bron,
                    COUNT(CASE WHEN avg_revenue BETWEEN 55000000 AND 59999999 THEN 1 END) AS Bron_plus,
                    -- COUNT(CASE WHEN avg_revenue BETWEEN 60000000 AND 100000000 THEN 1 END) AS Sil,
                    COUNT(CASE WHEN avg_revenue BETWEEN 60000000 AND 99999999 THEN 1 END) AS Sil,
                    COUNT(CASE WHEN avg_revenue BETWEEN 100000000 AND 199999999 THEN 1 END) AS Gol,
                    COUNT(CASE WHEN avg_revenue BETWEEN 200000000 AND 399999999 THEN 1 END) AS Pla,
                    COUNT(CASE WHEN avg_revenue > 400000000 THEN 1 END) AS Dia
                FROM (SELECT regional, revenue_m1, 
                        CASE WHEN ((revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
                                (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0)) = 0
                            THEN 0 
                            ELSE (revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / 
                                NULLIF(((revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
                                    (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0)),0) 
                        END AS avg_revenue, 
                        (availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 
                        AS average_availability  
                    FROM revenue
                ) AS revenue_calculation
                GROUP BY regional 
                ORDER BY regional DESC;";
        // --              COUNT(IF(  avg_availability < 90, 1, NULL)) AS total_P1a,
        // -- COUNT(IF(  avg_availability BETWEEN 90 AND 98, 1, NULL)) AS total_P2a,
        // -- COUNT(IF(  avg_availability > 98, 1, NULL)) AS total_Non_Program,
        //   COUNT(CASE WHEN average_availability < 90 THEN 1 END) AS completed_orders, -- Pesanan yang selesai
        //             -- WHERE revenue_category = 'Pla'

        $query = $db->query($sql);
        $results = $query->getResult();

        // echo '<pre>';
        // var_dump($results);
        // exit;
        return $results;
    }
    public function getFilterData()
    {
        $db = \Config\Database::connect();

        $sql = "SELECT 
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
                        (revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / 6 AS average_revenue
                    FROM revenue
                ) AS revenue_avg
                GROUP BY category";

        $query = $db->query($sql);
        $results = $query->getResult();

        return $results;
    }

    protected function minusDate($data, $type)
    {
        $date = new DateTime($data);

        $date->modify("-1 $type");

        // $converted = $this->converTanggal($date->format('Y-m-d')); 
        return $date->format('Y-m-d');
    }
    //     SELECT site_id, ((revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / 
    //                NULLIF( ( (revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
    //                          (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0) ), 0)) AS avg_revenue,
    //        (availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 AS avg_availibility
    // FROM revenue 
    // WHERE (availability_m1 + availability_m2 + availability_m3 + availability_m4 + availability_m5 + availability_m6) / 6 
    //       BETWEEN 90 AND 97.99
    // AND (
    //       CASE 
    //           WHEN ( (revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
    //                  (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0) ) = 0
    //           THEN 0 
    //           ELSE (revenue_m1 + revenue_m2 + revenue_m3 + revenue_m4 + revenue_m5 + revenue_m6) / 
    //                NULLIF( ( (revenue_m1 <> 0) + (revenue_m2 <> 0) + (revenue_m3 <> 0) + 
    //                          (revenue_m4 <> 0) + (revenue_m5 <> 0) + (revenue_m6 <> 0) ), 0) 
    //       END 
    //       BETWEEN 55000000 AND 59999999)
    // AND regional ='Sumbagut';
}
