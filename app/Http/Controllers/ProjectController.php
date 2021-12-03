<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Project_resp;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::all();

        foreach ($projects as $key => $value) {
            $value['resps'] = Project_resp::where('id', $value->id)->get();
        }

        dd($projects);
        return view('projects', ['projects' => $projects]);
    }

    public function store(Request $request) {

        $data = $request->except('_token');

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        Project::insert($data);

        return Redirect()->route('projects')->with('success', 'Project saved successfully!');
    }

    public function update(Request $request, $id) {
        $data = $request->except(['_method', '_token']);

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        Project::where('id', $id)->update($data);

        return Redirect()->route('projects')->with('success', 'Project updated successfully!');
    }

    public function delete($id) {
        Project::where('id', $id)->delete();
        return Redirect()->route('projects')->with('success', 'Project deleted successfully!');
    }
}
