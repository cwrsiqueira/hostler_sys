<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index() {
        return view('projects');
    }

    public function create(Request $request) {
        $data = $request->all([
            'name',
            'company',
            'phone',
            'email'
        ]);

        dd($data);
    }
}
