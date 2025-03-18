<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Status::orderBy('created_at', 'DESC')->get();
        return view('admin.status.status')->with('data', $data);
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
            'status' => 'required|string|max:255',
            'info'     => 'nullable|string',
        ]);

        Status::create([
            'status' => $validated['status'],
            'info'     => $validated['info'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('status.index')->with('success', 'Data status berhasil ditambahkan.');
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
    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
            'info'     => 'nullable|string',
        ]);

        $status->update($validated);

        return redirect()->route('status.index')->with('success', 'Data status berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('status.index')->with('success', 'Data status berhasil dihapus.');
    }
}
