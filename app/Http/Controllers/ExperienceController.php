<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest;
use App\Models\Experience;
use Inertia\Inertia;

class ExperienceController extends Controller
{
    public function index()
    {
        return Inertia::render('Experiences/Index', [
            'experiences' => Experience::where('user_id', auth()->id())->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Experiences/Create');
    }

    public function store(StoreExperienceRequest $request)
    {
        Experience::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return redirect()->route('experiences.index')->with('success', 'Pengalaman berhasil ditambahkan!');
    }

    public function edit(Experience $experience)
    {
        return Inertia::render('Experiences/Edit', ['experience' => $experience]);
    }

    public function update(StoreExperienceRequest $request, Experience $experience)
    {
        $experience->update($request->validated());

        return redirect()->route('experiences.index')->with('success', 'Pengalaman berhasil diperbarui!');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return back()->with('success', 'Pengalaman berhasil dihapus!');
    }
}
