<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\RevenueModel;
use App\Models\RoleModel;

class RevenueController extends BaseController
{
    public function index(): string
    {
        $model = new RevenueModel();

        $filterdata = $model->getFilterData();
        $filterdata[] = (object) ['category' => 'All'];
        $category = $filterdata[0]->category;
        $params =  $this->request->getPost('catrequest') ?? $category;
        $datas = $model->getAccountData($params);
        $alldata = $model->getAllData();

        return view('revenue/index', compact('filterdata', 'datas', 'params', 'alldata', 'model'));
    }
    public function import()
    {

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $file = $this->request->getFile('excel_file');

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
                $datatoinsert[$key]['availability_m1'] = ((int) str_replace('%', '', $row[10])) / 100;
                $datatoinsert[$key]['availability_m2'] = ((int) str_replace('%', '', $row[11])) / 100;
                $datatoinsert[$key]['availability_m3'] = ((int) str_replace('%', '', $row[12])) / 100;
                $datatoinsert[$key]['availability_m4'] = ((int) str_replace('%', '', $row[13])) / 100;
                $datatoinsert[$key]['availability_m5'] = ((int) str_replace('%', '', $row[14])) / 100;
                $datatoinsert[$key]['availability_m6'] = ((int) str_replace('%', '', $row[15])) / 100;
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
                $result[$key]['availability_m1'] = ((int) str_replace('%', '', $row[10])) / 100;
                $result[$key]['availability_m2'] = ((int) str_replace('%', '', $row[11])) / 100;
                $result[$key]['availability_m3'] = ((int) str_replace('%', '', $row[12])) / 100;
                $result[$key]['availability_m4'] = ((int) str_replace('%', '', $row[13])) / 100;
                $result[$key]['availability_m5'] = ((int) str_replace('%', '', $row[14])) / 100;
                $result[$key]['availability_m6'] = ((int) str_replace('%', '', $row[15])) / 100;
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
    public function getRoles()
    {
        if ($this->request->getMethod() === 'POST') {
            $model = new RoleModel();
            $roles = $model->findAll();
            return $this->response->setJSON($roles);
        }
        return $this->response->setJSON(['error' => 'Invalid request'], 400);
    }


    public function storeUser()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama' => 'required',
            'email' => 'required|valid_email',
            'role' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/revenue')->with('u_failed', $validation->getErrors());
        }

        $model = new PegawaiModel();
        $model->save([
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'role_id' => $this->request->getPost('role'),
            'is_deleted' => 0,
            'idt' => date('Y-m-d H:i:s'),
            'udt' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/revenue')->with('u_message', 'Data added successfully!');
    }

    public function sendEmail()
    {

        $model = new PegawaiModel();
        $datas = $model->select('pegawai.email,role.nama_role')
            ->join('role', 'role.id = pegawai.role_id')
            // ->where('role.nama_role', RoleModel::ROLE_MANAGER)
            ->where('pegawai.is_deleted', 0)
            ->findAll();


        // $filtermanager = array_filter($datas, function ($v) {
        //     return $v['nama_role'] === RoleModel::ROLE_MANAGER;
        // });
        // $emailList = array_column($filtermanager, 'email');
        $emailListManager = array_column(array_filter($datas, fn($v) => $v['nama_role'] === RoleModel::ROLE_MANAGER), 'email');
        $emailListSuperisor = array_column(array_filter($datas, fn($v) => $v['nama_role'] === RoleModel::ROLE_SUPERVISOR), 'email');
        $emailListStaff = array_column(array_filter($datas, fn($v) => $v['nama_role'] === RoleModel::ROLE_STAFF), 'email');

        $file = $this->request->getFile('file');
        if (!$file->isValid()) {
            return redirect()->to('/revenue')->with('failed', 'Data File Tidak Valid!');
        }
        $email = \Config\Services::email();
        $email->setFrom('muhammad.arya7831@gmail.com', 'Muh Arya'); // Pengirim
        $email->setTo($emailListStaff);
        $email->setCc($emailListManager);
        $email->setBCC($emailListSuperisor);
        $email->setSubject('Test Email from CodeIgniter 4');
        $email->setMessage('<h3>Halo , this is a test email from CI4!</h3>');
        $email->attach($file->getTempName(), 'application/octet-stream', $file->getName());
        $email->send();
        if ($email->send()) {
            return redirect()->to('/revenue')->with('message', 'Email successfully sent!');
        } else {
            // return redirect()->to('/revenue')->with('failed', 'Failed sent!');
            return redirect()->to('/revenue')->with('failed', 'Email successfully sent!');
            // echo '<pre>';
            // var_dump($email->printDebugger(['headers']));
            // exit;
        }
    }
    public function getUser()
    {
        $request = service('request');

        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $searchValue = $request->getPost('search') ?? '';
        $reqpost = $this->request->getPost();

        $model = new PegawaiModel();
        // $documents = $model;
        // if (!empty($searchValue)) {
        //     $documents = $model->like('doc_name', $searchValue || '');
        // }
        // $documents = $model->find();

        $documents = $model->where('is_deleted', 0)
            ->limit((int)$length, (int)$start)
            ->find();

        $start1 = intval($reqpost['start']);
        $data = [];
        foreach ($documents as $key => $doc) {
            $data[] = [
                'no' => $start1 + $key + 1,
                'nama' => $doc['nama'],
                'email' => $doc['email'],
                'r' => $model->role($doc['role_id'])['nama_role']
            ];
        }


        return $this->response->setJSON([
            'data' => $data,
            'start' => $start,
            'draw' => $this->request->getPost('draw'),
            'recordsTotal' => $model->countAllData(),
            'recordsFiltered' => $model->countFiltered($reqpost),
        ]);
    }

    public function detailSite()
    {
        // $param = $this->request->getGet();

        // $model = new RevenueModel();
        // $sites = $model->getDetailSite($param);

        // // $start1 = intval($reqpost['start']);
        // $data = [];
        // foreach ($sites as $key => $doc) {
        //     $data[] = [
        //         // 'no' => $start1 + $key + 1,
        //         'site_id' => $doc->site_id,
        //         'revenue_m1' => $doc->revenue_m1,
        //         'revenue_m2' => $doc->revenue_m2,
        //         'revenue_m3' => $doc->revenue_m3,
        //         'revenue_m4' => $doc->revenue_m4,
        //         'revenue_m5' => $doc->revenue_m5,
        //         'revenue_m6' => $doc->revenue_m6,
        //         'availability_m1' => $doc->availability_m1,
        //         'availability_m2' => $doc->availability_m2,
        //         'availability_m3' => $doc->availability_m3,
        //         'availability_m4' => $doc->availability_m4,
        //         'availability_m5' => $doc->availability_m5,
        //         'availability_m6' => $doc->availability_m6,
        //     ];
        // }
        // echo '<pre>';
        // var_dump($data);
        // exit;
        return view('revenue/detail_site');
    }
    // public function getDataSite()
    // {
    //     // $param = $this->request->getGet();


    //     $request = service('request');

    //     $start = $request->getPost('start');
    //     $length = $request->getPost('length');
    //     $searchValue = $request->getPost('search') ?? '';
    //     $reqpost = $this->request->getPost();
    //     $regional = $this->request->getPost('regional');
    //     $avail = $this->request->getPost('avail');
    //     $revenue_cat = $this->request->getPost('revenue_cat');

    //     $model = new RevenueModel();
    //     $sites = $model->getDetailSite($regional, $avail, $revenue_cat, $length, $start);
    //     // $documents = $model;
    //     // if (!empty($searchValue)) {
    //     //     $documents = $model->like('doc_name', $searchValue || '');
    //     // }
    //     // $documents = $model->find();


    //     $start1 = intval($reqpost['start']);
    //     $data = [];
    //     foreach ($sites as $key => $doc) {
    //         $data[] = [
    //             'no' => $start1 + $key + 1,
    //             'site_id' => $doc->site_id
    //             // 'revenue_m1' => $doc->revenue_m1,
    //             // 'revenue_m2' => $doc->revenue_m2,
    //             // 'revenue_m3' => $doc->revenue_m3,
    //             // 'revenue_m4' => $doc->revenue_m4,
    //             // 'revenue_m5' => $doc->revenue_m5,
    //             // 'revenue_m6' => $doc->revenue_m6,
    //             // 'availability_m1' => $doc->availability_m1,
    //             // 'availability_m2' => $doc->availability_m2,
    //             // 'availability_m3' => $doc->availability_m3,
    //             // 'availability_m4' => $doc->availability_m4,
    //             // 'availability_m5' => $doc->availability_m5,
    //             // 'availability_m6' => $doc->availability_m6,
    //         ];
    //     }

    //     return $this->response->setJSON([
    //         'data' => $data,
    //         'start' => $start,
    //         'draw' => $this->request->getPost('draw'),
    //         'recordsTotal' => $model->countAllData($length, $start),
    //         'recordsFiltered' => $model->countFiltered($reqpost, $length, $start),
    //     ]);
    // }
    public function getDataSite()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = (int) $request->getPost('start');
        $length = (int) $request->getPost('length');
        $regional = $request->getPost('regional');
        $avail = $request->getPost('avail');
        $revenue_cat = $request->getPost('revenue_cat');

        $model = new RevenueModel();

        // Total semua data (tanpa filter)
        $totalRecords = $model->countAllData(); // Sesuaikan dengan cara menghitung total data

        $totalFiltered = $model->countFilteredData($regional, $avail, $revenue_cat);

        $data = $model->getDetailSite($regional, $avail, $revenue_cat, $length, $start);

        $result = [
            "draw"            => intval($draw),
            "recordsTotal"    => $totalFiltered,
            "recordsFiltered" => $totalFiltered,
            "data"            => []
        ];

        $no = $start + 1;
        foreach ($data as $row) {
            $result['data'][] = [
                'no'      => $no++,
                'site_id' => $row->site_id,
                'revenue_m1' => $row->revenue_m1,
                'revenue_m2' => $row->revenue_m2,
                'revenue_m3' => $row->revenue_m3,
                'revenue_m4' => $row->revenue_m4,
                'revenue_m5' => $row->revenue_m5,
                'revenue_m6' => $row->revenue_m6,
                'availability_m1' => $row->availability_m1,
                'availability_m2' => $row->availability_m2,
                'availability_m3' => $row->availability_m3,
                'availability_m4' => $row->availability_m4,
                'availability_m5' => $row->availability_m5,
                'availability_m6' => $row->availability_m6,
            ];
        }

        return $this->response->setJSON($result);
    }
}
