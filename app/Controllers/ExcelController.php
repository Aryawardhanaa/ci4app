<?php

namespace App\Controllers;

use App\Models\ExcelModel;
use CodeIgniter\HTTP\ResponseInterface;

class ExcelController extends BaseController
{
    public function index(): string
    {
        return view('excel/index');
    }
    public function loadData()
    {
        $request = service('request');

        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $searchValue = $request->getPost('search') ?? '';
        $reqpost = $this->request->getPost();

        $documentModel = new ExcelModel();
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
    public function import()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $file = $this->request->getFile('file_excel');

        $monthyear = $this->request->getPost('monthyear');

        if ($file->getSize() == 0 || empty($monthyear)) {
            return redirect()->back()->with('failed', 'The file and date cannot be null !');
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

        array_shift($data);


        $isAllNumeric =  $this->isAllNumeric($data, 9);
        $isValidDate =  $this->isValidDate($data, 10, 11);
        $isNotNullKode =  $this->isNotNull($data, 0, 1, 3);

        if (!$isAllNumeric) {
            return redirect()->back()->with('failed', 'Total Must Contain Number ! ');
        }
        if (!$isValidDate) {
            return redirect()->back()->with('failed', 'Periode awal or Periode Akhir Must Contain valid date ! ');
        }
        if (!$isNotNullKode) {
            return redirect()->back()->with('failed', 'Kode Dokumen or Kategori Dokumen or Kode Akun 2 Cannot be null! ');
        }
        $model = new ExcelModel();

        $query = $model->where([
            'is_deleted' => 0,
            'month_year'   => $monthyear . '-01'
        ]);

        $exist = $query->first();
        if (isset($exist)) {
            $updateBatchData = [];
            foreach ($query->findAll() as $row) {
                $updateBatchData[] = [
                    'id'         => $row['id'],
                    'is_deleted' => 1,
                    'udt' => date('Y-m-d H:i:s')
                ];
            }

            if (!empty($updateBatchData)) {
                $model->updateBatch($updateBatchData, 'id');
            }
        }
        $result = [];
        foreach ($data as $key => $row) {
            $result[$key]['kode_dokumen'] = $row[0];
            $result[$key]['kategori_dokumen'] = $row[1];
            $result[$key]['kode_akun_1'] = $row[2];
            $result[$key]['kode_akun_2'] = $row[3];
            $result[$key]['kode_akun_3'] = $row[4];
            $result[$key]['kode_akun_4'] = $row[5];
            $result[$key]['tanggal_dokumen'] = $row[6];
            $result[$key]['periode_dokumen'] = $row[7];
            $result[$key]['tipe_dokumen'] = $row[8];
            $result[$key]['total'] = (int)str_replace(',', '', $row[9]);
            $result[$key]['periode_awal'] = $row[10];
            $result[$key]['periode_akhir'] = $row[11];
            $result[$key]['month_year'] = $monthyear . '-01';
            $result[$key]['is_deleted'] =  0;
            $result[$key]['idt'] = date('Y-m-d H:i:s');
            $result[$key]['udt'] = date('Y-m-d H:i:s');
        }

        $model->insertBatch($result);

        return redirect()->to('/excel')->with('message', 'Data added successfully!');
    }

    protected function isAllNumeric(array $data, $index)
    {
        foreach ($data as $row) {
            if (isset($row[$index]) && !preg_match('/^-?\d+(\.\d+)?$/', str_replace(',', '', $row[$index]))) {
                return false;
            }
        }
        return true;
    }
    protected function isValidDate(array $data, $index, $index2)
    {
        foreach ($data as $row) {
            if (isset($row[$index]) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $row[$index])) {
                return false;
            }
            if (isset($row[$index2]) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $row[$index2])) {
                return false;
            }
        }
        return true;
    }
    protected function isNotNull(array $data, $index, $index2, $index3)
    {
        foreach ($data as $row) {
            if (!isset($row[$index])) {
                return false;
            }
            if (!isset($row[$index2])) {
                return false;
            }
            if (!isset($row[$index3])) {
                return false;
            }
        }
        return true;
    }
}
