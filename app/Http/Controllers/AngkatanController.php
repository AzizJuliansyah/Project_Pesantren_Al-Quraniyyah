<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Angkatan::all();;
        return view('admin.angkatan.angkatan')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'angkatan' => 'required|string|max:255',
            'info'     => 'nullable|string',
        ]);

        Angkatan::create([
            'angkatan' => $validated['angkatan'],
            'info'     => $validated['info'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('angkatan.index')->with('success', 'Data angkatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Angkatan $angkatan)
    {
        $validated = $request->validate([
            'angkatan' => 'required|string|max:255',
            'info'     => 'nullable|string',
        ]);

        $angkatan->update($validated);

        return redirect()->route('angkatan.index')->with('success', 'Data angkatan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Angkatan $angkatan)
    {
        $angkatan->delete();
        return redirect()->route('angkatan.index')->with('success', 'Data angkatan berhasil dihapus.');
    }
}
