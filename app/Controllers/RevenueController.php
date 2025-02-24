<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\RevenueModel;

class RevenueController extends BaseController
{
    public function index(): string
    {
        $model = new RevenueModel();

        // echo '<pre>';
        // var_dump(count($model->findAll()));
        // exit;
        $filterdata = $model->getFilterData();
        $filterdata[] = (object) ['category' => 'All'];
        $category = $filterdata[0]->category;
        $params =  $this->request->getPost('catrequest') ?? $category;
        $datas = $model->getAccountData($params);
        $alldata = $model->getAllData();

        return view('revenue/index', compact('filterdata', 'datas', 'params', 'alldata'));
    }
    public function import()
    {

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $file = $this->request->getFile('excel_file');
        // $files = $this->request->getFiles();
        // echo '<pre>';
        // var_dump($file);
        // exit;

        if ($file->getSize() == 0) {
            return redirect()->back()->with('failed', 'The file cannot be null !');
        }
        if ($file->getClientExtension() != 'xlsx') {
            return redirect()->back()->with('failed', 'The file must be in XLSX format !');
        }
        if ($file->getSize() > 1024 * 1024 * 20) {
            return redirect()->back()->with('failed', 'file Must Smaller Than 20 MB !');
        }

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet =  $reader->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();

        // echo '<pre>';
        // var_dump($data);
        // exit;
        // array_shift($data);
        array_splice($data, 0, 2);

        $result = [];
        $datatoinsert = [];
        $model2 = new RevenueModel();
        foreach ($data as $key => $row) {
            $query = $model2->where(['site_id' => $row[1]]);
            $exist = $query->first();
            if (!isset($exist)) {
                $datatoinsert[$key]['site_id'] = $row[1];
                $datatoinsert[$key]['site_label'] = $row[2];
                $datatoinsert[$key]['regional'] = $row[3];
                $datatoinsert[$key]['revenue_m1'] = (float) str_replace([',', " "], '', $row[4]);
                $datatoinsert[$key]['revenue_m2'] = (float) str_replace([',', " "], '', $row[5]);
                $datatoinsert[$key]['revenue_m3'] = (float) str_replace([',', " "], '', $row[6]);
                $datatoinsert[$key]['revenue_m4'] = (float) str_replace([',', " "], '', $row[7]);
                $datatoinsert[$key]['revenue_m5'] = (float) str_replace([',', " "], '', $row[8]);
                $datatoinsert[$key]['revenue_m6'] = (float) str_replace([',', " "], '', $row[9]);
                $datatoinsert[$key]['availability_m1'] = (int) str_replace('%', '', $row[10]);
                $datatoinsert[$key]['availability_m2'] = (int) str_replace('%', '', $row[11]);
                $datatoinsert[$key]['availability_m3'] = (int) str_replace('%', '', $row[12]);
                $datatoinsert[$key]['availability_m4'] = (int) str_replace('%', '', $row[13]);
                $datatoinsert[$key]['availability_m5'] = (int) str_replace('%', '', $row[14]);
                $datatoinsert[$key]['availability_m6'] = (int) str_replace('%', '', $row[15]);
            }
            if (isset($exist)) {
                $result[$key]['site_id'] = $row[1];
                $result[$key]['site_label'] = $row[2];
                $result[$key]['regional'] = $row[3];
                $result[$key]['revenue_m1'] = (float) str_replace([',', " "], '', $row[4]);
                $result[$key]['revenue_m2'] = (float) str_replace([',', " "], '', $row[5]);
                $result[$key]['revenue_m3'] = (float) str_replace([',', " "], '', $row[6]);
                $result[$key]['revenue_m4'] = (float) str_replace([',', " "], '', $row[7]);
                $result[$key]['revenue_m5'] = (float) str_replace([',', " "], '', $row[8]);
                $result[$key]['revenue_m6'] = (float) str_replace([',', " "], '', $row[9]);
                $result[$key]['availability_m1'] = (int) str_replace('%', '', $row[10]);
                $result[$key]['availability_m2'] = (int) str_replace('%', '', $row[11]);
                $result[$key]['availability_m3'] = (int) str_replace('%', '', $row[12]);
                $result[$key]['availability_m4'] = (int) str_replace('%', '', $row[13]);
                $result[$key]['availability_m5'] = (int) str_replace('%', '', $row[14]);
                $result[$key]['availability_m6'] = (int) str_replace('%', '', $row[15]);
            }
        }

        $model = new RevenueModel();
        if (count($datatoinsert) > 0) {
            // $model->findAll();
            $model->insertBatch($datatoinsert);
        }
        if (count($result) > 0) {
            $model->updateBatch($result, 'site_id');
        }


        // array_shift($data);




        return redirect()->to('/revenue')->with('message', 'Data added successfully!');
    }

    public function loadUser()
    {
        $request = service('request');

        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $searchValue = $request->getPost('search') ?? '';
        $reqpost = $this->request->getPost();

        $documentModel = new PegawaiModel();
        // $documents = $documentModel;
        // if (!empty($searchValue)) {
        //     $documents = $documentModel->like('doc_name', $searchValue || '');
        // }
        // $documents = $documentModel->find();

        $documents = $documentModel->where('is_deleted', 0)
            ->limit((int)$length, (int)$start)
            ->find();

        $start1 = intval($reqpost['start']);
        $data = [];
        foreach ($documents as $key => $doc) {
            // $doc->no = $start1 +$key+1;
            $data[] = [
                'id' => $doc['id'],  // id
                'no' => $start1 + $key + 1, // Nomor Urut
                'kode_dokumen' => esc($doc['kode_dokumen']),
                'idt' => esc($doc['idt'])
            ];
        }


        return $this->response->setJSON([
            'data' => $data,
            'start' => $start,
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $documentModel->countAllData(),
            'recordsFiltered' => $documentModel->countFiltered($reqpost),
        ]);
    }
}
