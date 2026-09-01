<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Models\Skill;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function index()
    {
        return Inertia::render('Skills/Index', [
            'skills' => Skill::where('user_id', auth()->id())->orderBy('category')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Skills/Create');
    }

    public function store(StoreSkillRequest $request)
    {
        Skill::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return redirect()->route('skills.index')->with('success', 'Skill berhasil ditambahkan!');
    }

    public function edit(Skill $skill)
    {
        return Inertia::render('Skills/Edit', ['skill' => $skill]);
    }

    public function update(StoreSkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        return redirect()->route('skills.index')->with('success', 'Skill berhasil diperbarui!');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return back()->with('success', 'Skill berhasil dihapus!');
    }
}
