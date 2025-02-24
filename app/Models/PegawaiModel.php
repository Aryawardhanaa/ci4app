<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

class PegawaiModel extends Model
{
    protected $table      = 'pegawai';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_role',
        'role_id',
        'is_deleted',
        'idt',
        'udt'
    ];


    public function getDataTables($request)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, nama_role, role_id, is_deleted, idt', 'udt'); // Adjust fields as needed
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

    protected function minusDate($data, $type)
    {
        $date = new DateTime($data);

        $date->modify("-1 $type");

        // $converted = $this->converTanggal($date->format('Y-m-d')); 
        return $date->format('Y-m-d');
    }
}
