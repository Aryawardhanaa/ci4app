<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class ExcelModel extends Model
{
    protected $table      = 'excel';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_dokumen',
        'kategori_dokumen',
        'kode_akun_1',
        'kode_akun_2',
        'kode_akun_3',
        'kode_akun_4',
        'tanggal_dokumen',
        'periode_dokumen',
        'tipe_dokumen',
        'total',
        'periode_awal',
        'periode_akhir',
        'month_year',
        'is_deleted',
        'idt',
        'udt'
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

    public function getAccountData($isempty, $param)
    {
        $startMom = $isempty != 0 ? $this->minusDate($param, 'month') : date('Y-m-d');
        $startYoy =  $isempty != 0 ? $this->minusDate($param, 'year') : date('Y-m-d');

        $endmonth = $param;
        $builder = $this->builder();
        $aliasMom = converTanggal($startMom);
        $aliasparam = converTanggal($param);
        $aliasYoy = converTanggal($startYoy);
        $builder->select([
            "LEFT(kode_akun_2, 2) AS kode_akun_2",
            "SUM(CASE WHEN month_year = '$startMom' THEN total ELSE 0 END) AS '$aliasMom'",
            "SUM(CASE WHEN month_year = '$param' THEN total ELSE 0 END) AS '$aliasparam'",
            "SUM(CASE WHEN month_year = '$startYoy' THEN total ELSE 0 END) AS '$aliasYoy'",
        ])->join('category_account_2', "category_account_2.code_account = excel.kode_akun_2 AND LEFT(excel.kode_akun_2, 2)", 'left', false)

            // ->join('category_account_2', 'category_account_2.code_account = excel.kode_akun_2', 'left')
            // ->whereIn('LEFT(kode_akun_2, 2)', ['52', '53', '54', '55', '56'])
            ->groupBy('LEFT(kode_akun_2, 2)');

        // Menjalankan query dan mengembalikan hasilnya
        return $builder->get()->getResultArray();
    }
    public function getAcountRegion()
    {
        $builder = $this->builder();

        $builder->select([
            "LEFT(excel.kode_akun_2, 2) AS kode_akun_2",
            "SUM(CASE WHEN excel.kategori_dokumen = '20' THEN excel.total ELSE 0 END) AS Sumatera",
            "SUM(CASE WHEN excel.kategori_dokumen = '21' THEN excel.total ELSE 0 END) AS Sumbagut",
            "SUM(CASE WHEN excel.kategori_dokumen = '22' THEN excel.total ELSE 0 END) AS Sumbagsel",
            "SUM(CASE WHEN excel.kategori_dokumen = '23' THEN excel.total ELSE 0 END) AS Sumbagteng",
            "ca.desc"
        ])
            ->join('category_account_2 ca', "ca.code_account = LEFT(excel.kode_akun_2, 2)", 'left', false)
            ->where('excel.is_deleted', 0)
            ->groupBy("LEFT(excel.kode_akun_2, 2)");

        return $builder->get()->getResultArray();
    }

    protected function minusDate($data, $type)
    {
        $date = new DateTime($data);

        $date->modify("-1 $type");

        // $converted = $this->converTanggal($date->format('Y-m-d')); 
        return $date->format('Y-m-d');
    }
}
