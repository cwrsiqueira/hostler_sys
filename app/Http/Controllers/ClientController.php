<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Client;

class ClientController extends Controller
{
    public function index() {
        $clients = Client::select('id', 'name', 'phone')->get();
        return view('clients', ['clients' => $clients]);
    }

    public function store(Request $request) {

        $data = $request->except('_token');

        $validated = $request->validate([
            'name' => 'required|max:255',
            'company' => 'required|max:255',
            'phone' => 'max:255',
            'email' => 'required|max:255|unique:clients',
        ]);

        Client::insert($data);

        return Redirect()->route('clients')->with('success', 'Client saved successfully!');
    }
}
