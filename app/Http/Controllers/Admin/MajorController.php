<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        return view('admin.master.major', [
            'title' => 'Jurusan'
        ]);
    }
}
