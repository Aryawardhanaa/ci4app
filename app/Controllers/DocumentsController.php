<?php

namespace App\Controllers;

use App\Models\DocumentsModel;
use CodeIgniter\Controller;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use Faker\Provider\Base;

class DocumentsController extends BaseController
{
    public function index()
    {
        $model = new DocumentsModel();
        $datas = $model->findAll();

        // echo '<pre>';
        // var_dump($datas);
        // exit;
        return view('home/index', compact('datas'));
    }


    // public function loadData()
    // {
    //     $model = new DocumentsModel();
    //     $datas = $model->findAll();
    //     return $this->response->setJSON(['data' => $datas]);
    // }
    public function loadData()
    {
        $request = service('request');

        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $searchValue = $request->getPost('search') ?? '';
        $reqpost = $this->request->getPost();

        $documentModel = new DocumentsModel();
        // $documents = $documentModel;
        // if (!empty($searchValue)) {
        //     $documents = $documentModel->like('doc_name', $searchValue || '');
        // }
        // $documents = $documentModel->find();
        $documents = $documentModel
            ->limit((int)$length, (int)$start)
            ->find();

        $start1 = intval($reqpost['start']);
        $data = [];
        foreach ($documents as $key => $doc) {
            $data[] = [
                'id' => $doc['id'],  // id
                'no' => $start1 + $key + 1, // Nomor Urut
                'doc_name' => esc($doc['doc_name']),
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
    public function download($id)
    {
        $berkas = new DocumentsModel();
        $data = $berkas->find($id);
        // echo '<pre>';
        // var_dump($data);
        // exit;
        return $this->response->download('uploads/' . $data['upload_file'], null);
    }
    // public function download($filename)
    // {
    //     // Lokasi file (pastikan file berada di WRITEPATH atau bisa diakses)
    //     $filepath = WRITEPATH . 'uploads/' . $filename;

    //     // Cek apakah file ada
    //     if (!file_exists($filepath)) {
    //         return redirect()->back()->with('error', 'File tidak ditemukan.');
    //     }

    //     // Unduh file
    //     return $this->response->download($filepath, null);
    // }
    // public function create()
    // {
    //     return view('products/create');
    // }
    public function store()
    {

        // $model = new DocumentsModel();
        // $model->save([
        //     'doc_name' => $this->request->getPost('doc_name'),
        // ]);
        // var_dump($this->request->getPost('doc_name'));
        // exit;
        $model = new DocumentsModel();
        $file = $this->request->getFile('documents');
        // if (!validateFileSize($file, 10)) {
        //     return redirect()->back()->with('error', 'File size exceeds 10MB limit.');
        // }

        // $newName = $file->getRandomName();
        // $file->move('uploads', $newName);

        // echo '<pre>';
        // var_dump($file->getSize() > 10000000);
        // exit;
        // Validasi agar hanya bisa mengupload dokumen
        $allowedMimeTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        $newName = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 1024 * 1024 * 10) {
                return redirect()->back()->with('failed', 'file Must Smaller Than 10 MB .');
            }
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, $allowedMimeTypes)) {
                return redirect()->back()->with('failed', 'Invalid file type! Only PDF, DOCX, XLSX allowed.');
            }
            $newName =  Time::now()->getTimestamp() . "_" . $file->getName();
            $file->move('uploads', $newName);
        }
        $model->save([
            'doc_name'  => $this->request->getPost('doc_name'),
            'idt'  => date('Y-m-d'),
            'upload_file' => $newName
        ]);
        // var_dump($this->request->getPost('documents'));
        // var_dump($file = $this->request->getFile('documents'));
        // exit;

        // $file = $this->request->getFile('document');

        // if ($file && $file->isValid() && !$file->hasMoved()) {
        //     $newName = $file->getRandomName();
        //     $file->move('uploads', $newName);
        // } else {
        //     $newName = null;
        // }

        // $this->model->save([
        //     'name'  => $this->request->getPost('name'),
        //     'price' => $this->request->getPost('price'),
        //     'document' => $newName
        // ]);

        return redirect()->to('/documents/index')->with('message', 'Product added successfully!');
    }

    // public function store()
    // {
    //     $model = new DocumentsModel();
    //     $file = $this->request->getFile('image');

    //     if ($file && $file->isValid() && !$file->hasMoved()) {
    //         $newName = $file->getRandomName();
    //         $file->move('uploads', $newName);
    //     } else {
    //         $newName = null;
    //     }

    //     $model->save([
    //         'name'  => $this->request->getPost('name'),
    //         'price' => $this->request->getPost('price'),
    //         'image' => $newName
    //     ]);

    //     return redirect()->to('/products')->with('message', 'Documents added successfully!');
    // }

    public function edit($id)
    {
        $model = new DocumentsModel();
        $data['product'] = $model->find($id);
        return view('products/edit', $data);
    }

    public function update($id)
    {
        $model = new DocumentsModel();
        $product = $model->find($id);
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($product['image']) {
                unlink('uploads/' . $product['image']);
            }
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
        } else {
            $newName = $product['image'];
        }

        $model->update($id, [
            'name'  => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'image' => $newName
        ]);

        return redirect()->to('/products')->with('message', 'Documents updated successfully!');
    }

    public function delete($id)
    {
        $model = new DocumentsModel();
        $product = $model->find($id);

        if ($product['image']) {
            unlink('uploads/' . $product['image']);
        }

        $model->delete($id);
        return redirect()->to('/products')->with('message', 'Documents deleted successfully!');
    }
}
