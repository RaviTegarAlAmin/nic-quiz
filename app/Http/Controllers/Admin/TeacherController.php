<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    public function index()
    {
        return view('admin.Teacher.Index');
    }
}
