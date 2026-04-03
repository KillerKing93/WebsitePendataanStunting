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
        return view('children/index'); // Will be created later for datatable
    }

    public function create()
    {
        return view('children/create');
    }

    public function store()
    {
        // CRUD logic to be implemented
    }
}
