<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentsModel extends Model
{
    protected $table      = 'documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['doc_name', 'upload_file', 'idt'];


    public function getDataTables($request)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, doc_name, upload_file, idt'); // Adjust fields as needed

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
        return $this->db->table($this->table)->countAllResults();
    }
}
