<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::where('user_id', auth()->id())->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', ['project' => $project]);
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) Storage::disk('public')->delete($project->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) Storage::disk('public')->delete($project->thumbnail);
        $project->delete();

        return back()->with('success', 'Proyek berhasil dihapus!');
    }
}
