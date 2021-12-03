<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Client;

class ClientController extends Controller
{
    public function index() {
        $clients = Client::all();
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

    public function update(Request $request, $id) {
        $data = $request->except(['_method', '_token']);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'company' => 'required|max:255',
            'phone' => 'max:255',
            'email' => ['required', 'max:255', Rule::unique('clients')->ignore($id)],
        ]);

        Client::where('id', $id)->update($data);

        return Redirect()->route('clients')->with('success', 'Client updated successfully!');
    }

    public function delete($id) {
        Client::where('id', $id)->delete();
        return Redirect()->route('clients')->with('success', 'Client deleted successfully!');
    }
}
