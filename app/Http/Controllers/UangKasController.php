<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Angkatan;
use App\Models\Campaign;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class UangKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $campaign = Campaign::findOrFail(1);

        $query = Donasi::where('campaign_id', 1);

        $angkatan = $request->input('angkatan');
        $dari = $request->input('dari');
        $hingga = $request->input('hingga');
        $nama = $request->input('nama');
        $order_id = $request->input('order_id');
        $status = $request->input('status');
        $hasFilters = false;

        // Filter berdasarkan tanggal
        if ($request->has('dari') && $request->dari) {
            $query->where('created_at', '>=', $dari);
            $hasFilters = true;
        }
        if ($request->has('hingga') && $request->hingga) {
            $query->where('created_at', '<=', $hingga);
            $hasFilters = true;
        }

        // Filter berdasarkan angkatan
        if ($request->has('angkatan') && $request->angkatan && $angkatan != 'default') {
            $query->whereHas('alumni', function ($q) use ($angkatan) {
                $q->where('angkatan_id', $angkatan);
            });
            $hasFilters = true;
        }

        // Filter berdasarkan nama
        if ($request->has('nama') && $request->nama) {
            $query->whereHas('alumni', function ($q) use ($nama) {
                $q->where('nama', 'LIKE', '%' . $nama . '%');
            });
            $hasFilters = true;
        }
        if ($request->has('order_id') && $request->order_id) {
            $query->where('order_id', 'like', '%' . $request->order_id . '%');
            $hasFilters = true;
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', 'like', '%' . $request->status . '%');
            $hasFilters = true;
        } else {
            $query->where('status', 'success');
        }

        $donasi = $query->get();
        $angkatan = Angkatan::all();

        return view('admin.uangkas.index', [
            'donasi' => $donasi,
            'hasFilters' => $hasFilters,
            'campaign' => $campaign,
            'angkatan' => $angkatan,
        ]);

    }

    public function pengeluaran()
    {
        $pengeluaran = Pengeluaran::all();
        return view('admin.uangkas.pengeluaran', compact('pengeluaran'));
    }

    public function tambahpengeluaran(Request $request)
    {
        $validated = $request->validate([
            'untuk' => 'required|string',
            'nominal' => 'required|integer',
            'yangbertanggungjawab'     => 'nullable|string',
        ]);

        Pengeluaran::create([
            'untuk' => $validated['untuk'],
            'nominal' => $validated['nominal'],
            'yangbertanggungjawab'     => $validated['yangbertanggungjawab'],
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('pengeluaran.uangkas')->with('success', 'Data angkatan berhasil ditambahkan.');
    }

    public function editpengeluaran(Request $request, $id)
    {
        $request->validate([
            'untuk' => 'required|string',
            'nominal' => 'required|integer',
            'yangbertanggungjawab' => 'nullable|string',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);

        $pengeluaran->update([
            'untuk' => $request->input('untuk'),
            'nominal' => $request->input('nominal'),
            'yangbertanggungjawab' => $request->input('yangbertanggungjawab'),
        ]);

        return redirect()->route('pengeluaran.uangkas')->with('success', 'Data pengeluaran berhasil diupdate.');
    }

    public function hapuspengeluaran($id)
    {
        Pengeluaran::where('id', $id)->delete();
        return redirect()->route('pengeluaran.uangkas')->with('success', 'pengeluaran berhasil dihapus.');
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
