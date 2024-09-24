<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumni;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get total alumni count
        $totalAlumni = Alumni::count();
        
        // Get all status and their corresponding alumni counts
        $status = Status::withCount('alumni')->get(); // Automatically adds alumni count for each status

        return view('admin.index', [
            'totalAlumni' => $totalAlumni,
            'status' => $status, // Pass the status with their respective counts
        ]);
    }





    public function getAlumniStatistics()
    {
        $statistics = Status::withCount('alumni')->get();

        $labels = $statistics->pluck('status');
        $data = $statistics->pluck('alumni_count');

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getNames()
    {
        $nama = Alumni::pluck('nama');
        return response()->json($nama);
    }


    public function getDetails($id)
    {
        $alumni = Alumni::with('angkatan')->find($id);

        return response()->json([
            'angkatan_id' => $alumni->angkatan_id,
            'angkatan' => $alumni->angkatan->angkatan,
        ]);
    }


    public function profile()
    {
        return view('admin.profile');
    }
    
    public function updateprofile(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatepassword(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'repeat_password' => 'required|same:new_password',
        ], [
            'new_password.different' => 'Password baru tidak boleh sama dengan password lama.',
            'new_password.min' => 'Minimal password adalah 8 karakter.',
            'new_password.regex' => 'Password harus mengandung huruf kecil, huruf besar, angka, dan karakter khusus.',
            'repeat_password.same' => 'Konfirmasi password harus sama dengan password baru.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Password lama tidak cocok.');
        }

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

}
