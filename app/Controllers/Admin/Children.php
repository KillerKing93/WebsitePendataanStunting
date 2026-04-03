<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\ChildrenModel;

class Children extends BaseController
{
    protected $childrenModel;

    public function __construct()
    {
        $this->childrenModel = new ChildrenModel();
    }

    public function index()
    {
        $data = [
            'children' => $this->childrenModel->findAll()
        ];
        return view('admin/children/index', $data);
    }

    public function create()
    {
        return view('children/create'); // Form Map (Sudah dibuat)
    }

    public function store()
    {
        // Ambil Posyandu terdaftar pertama. Jika kosong (database baru live), buat otomatis Dummy Posyandu
        $posyanduModel = new \App\Models\PosyanduModel();
        $posyandu = $posyanduModel->first();
        if (!$posyandu) {
            $posyanduModel->insert([
                'name' => 'Posyandu Melati Pusat',
                'address' => 'Kelurahan StuntingGIS Demo',
                'latitude' => -6.200,
                'longitude' => 106.816
            ]);
            $posyanduId = $posyanduModel->getInsertID();
        } else {
            $posyanduId = $posyandu['id'];
        }

        // Validasi dan Insert Data
        $data = [
            'name' => $this->request->getPost('name'),
            'nik' => $this->request->getPost('nik'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender' => $this->request->getPost('gender'),
            'parent_name' => $this->request->getPost('parent_name'),
            'address' => $this->request->getPost('address'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'posyandu_id' => $posyanduId, 
        ];
        
        $this->childrenModel->insert($data);
        return redirect()->to('/admin/children')->with('success', 'Data Balita dan Koordinat berhasil disimpan!');
    }
}
