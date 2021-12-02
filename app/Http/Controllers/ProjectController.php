<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index() {
        $projects = Client::select('id', 'name', 'email', 'phone', 'company')->get();
        return view('clients', ['clients' => $projects]);
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
