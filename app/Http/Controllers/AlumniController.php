<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Alumni;
use App\Models\Status;
use App\Models\Angkatan;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $angkatan_id = $request->input('angkatan');
        $dari = $request->input('dari');
        $hingga = $request->input('hingga');
        $search = $request->input('search');
        $angkatan = Angkatan::all();
        $status = Status::all();
        $dari = $dari ? \Carbon\Carbon::parse($dari)->startOfDay() : null;
        $hingga = $hingga ? \Carbon\Carbon::parse($hingga)->endOfDay() : null;
        $query = Alumni::query();
    
        $hasFilters = false;

        if ($request->has('angkatan') && $request->angkatan) {
            $query->where('angkatan_id', $request->angkatan);
            $hasFilters = true;
        }
        if ($request->has('status') && $request->status) {
            $query->where('status_id', $request->status);
            $hasFilters = true;
        }
        if ($request->has('dari') && $request->dari) {
            $query->whereDate('tanggal_lahir', '>=', $request->dari);
            $hasFilters = true;
        }
        if ($request->has('hingga') && $request->hingga) {
            $query->whereDate('tanggal_lahir', '<=', $request->hingga);
            $hasFilters = true;
        }
        if ($request->has('search') && $request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
            $hasFilters = true;
        }

        if (!$hasFilters) {
            $query->orderBy('created_at', 'DESC');
        }

        $alumni = $query->get();

        if ($alumni->isEmpty()) {
            return view('admin.alumni.index', [
                'angkatan' => $angkatan,
                'status' => $status,
                'alumni' => $alumni,
                'hasFilters' => $hasFilters,
                'noData' => true,
            ]);
        }
        return view('admin.alumni.index', [
            'angkatan' => $angkatan,
            'status' => $status,
            'alumni' => $alumni,
            'hasFilters' => $hasFilters,
        ]);
    }








    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $angkatan = Angkatan::all();
        $status = Status::all();
        return view('admin.alumni.tambahalumni', compact('angkatan', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|numeric',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'pendidikan_terakhir' => 'required|string|max:255',
            'angkatan' => 'required|integer',
            'status' => 'nullable|integer',
            'usaha' => 'nullable|string|max:255',
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'no_telepon' => $request->input('no_telepon'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'pendidikan_terakhir' => $request->input('pendidikan_terakhir'),
            'angkatan_id' => $request->input('angkatan'),
            'status_id' => $request->input('status'),
            'usaha' => $request->input('usaha'),
        ];

        Alumni::create($data);

        if ($request->input('action') === 'save_add') {
            return redirect()->route('alumni.create')->with('success', 'Data alumni berhasil disimpan! Silahkan tambah data lagi.');
        } elseif ($request->input('action') === 'save') {
            return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil disimpan!');
        }
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
    public function edit(string $slug)
    {
        
        $alumni = Alumni::where('slug', $slug)->first();
        $angkatan = Angkatan::all();
        $status = Status::all();
        if (!$alumni) {
            return redirect()->back()->with('error', 'Alumni not found');
        }

        return view('admin.alumni.editalumni', compact('alumni', 'angkatan', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|numeric',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'pendidikan_terakhir' => 'required|string|max:255',
            'angkatan' => 'required|integer',
            'status' => 'nullable|integer',
            'usaha' => 'nullable|string|max:255',
        ]);

        $alumni = Alumni::findOrFail($id);

        $alumni->update([
            'nama' => $request->input('nama'),
            'no_telepon' => $request->input('no_telepon'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'alamat' => $request->input('alamat'),
            'pendidikan_terakhir' => $request->input('pendidikan_terakhir'),
            'angkatan_id' => $request->input('angkatan'),
            'status_id' => $request->input('status'),
            'usaha' => $request->input('usaha'),
        ]);

        return redirect()->route('alumni.index')->with('success', 'Berhasil mengubah data alumni');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Alumni::where('id', $id)->delete();
        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil dihapus.');
    }



    
}
