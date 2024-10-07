<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Donasi;
use App\Models\Status;
use App\Models\Angkatan;
use App\Models\Campaign;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalAlumni = Alumni::count();
        
        $status = Status::withCount('alumni')->get();

        $selectedMonth = $request->input('month', null);
        $selectedYear = $request->input('year', null);
        $selectedCampaign = 1;
        $campaign = Campaign::findOrFail($selectedCampaign);

        $uangkasQuery = Donasi::with('campaign')
        ->where('status', 'success')
        ->where('campaign_id', $selectedCampaign);

        if ($selectedYear) {
            $uangkasQuery->whereYear('created_at', $selectedYear);
        }

        if ($selectedMonth) {
            $uangkasQuery->whereMonth('created_at', $selectedMonth);
        }

        $uangkas = $uangkasQuery->orderBy('id', 'DESC')->get();

        $monthlyTotals = array_fill(0, 12, 0);
        $weeklyTotals = array_fill(0, 4, 0);
        $totalUangKas = 0;

        // Hitung total bulanan dan mingguan
        foreach ($uangkas as $d) {
            $month = (int) Carbon::parse($d->created_at)->format('m') - 1;
            $monthlyTotals[$month] += floatval($d->nominal2);
            $totalUangKas += floatval($d->nominal2);

            // Hitung total mingguan hanya jika bulan dipilih
            if ($month + 1 == $selectedMonth) {
                $week = Carbon::parse($d->created_at)->weekOfMonth - 1;
                $weeklyTotals[$week] += floatval($d->nominal2);
            }
        }

        // Persentase kenaikan bulanan
        $currentMonthIndex = Carbon::now()->format('m') - 1;
        $previousMonthIndex = ($currentMonthIndex > 0) ? $currentMonthIndex - 1 : 11;
        $bulanSebelumnya = $monthlyTotals[$previousMonthIndex];
        $bulanIni = $monthlyTotals[$currentMonthIndex];
        $persentaseKenaikanBulanan = $bulanSebelumnya == 0 ? ($bulanIni > 0 ? 100 : 0) : (($bulanIni - $bulanSebelumnya) / $bulanSebelumnya) * 100;

        // Persentase kenaikan mingguan
        $totalWeekly = array_sum($weeklyTotals);
        $persentaseKenaikanMingguan = 0;
        $mingguSekarang = $weeklyTotals[count($weeklyTotals) - 1] ?? 0;
        $mingguSebelumnya = $weeklyTotals[count($weeklyTotals) - 2] ?? 0;
        if ($mingguSebelumnya == 0 && $mingguSekarang > 0) {
            $persentaseKenaikanMingguan = 100;
        } elseif ($mingguSebelumnya > 0) {
            $persentaseKenaikanMingguan = (($mingguSekarang - $mingguSebelumnya) / $mingguSebelumnya) * 100;
        } elseif ($mingguSebelumnya < 0) {
            $persentaseKenaikanMingguan = -abs($mingguSekarang) / abs($mingguSebelumnya) * 100;
        }

        
        $chartType = 'all'; // Default chart type

        if ($request->year && $request->month) {
            $chartType = 'monthInYear';
        } elseif ($request->year) {
            $chartType = 'yearly';
        } elseif ($request->month) {
            $chartType = 'weekly';
        }

        $chartData = [
            'chartType' => $chartType,
            'monthlyTotals' => $monthlyTotals,
            'weeklyTotals' => $weeklyTotals,
            'persentaseKenaikanBulanan' => $persentaseKenaikanBulanan,
            'persentaseKenaikanMingguan' => $persentaseKenaikanMingguan,
            'total' => $totalUangKas,
            'totalWeekly' => $totalWeekly,
        ];

        $pengeluaranTotalUangKas = Pengeluaran::sum('nominal');
        $saldoAwalUangKas = Donasi::where('campaign_id', $selectedCampaign)
                                    ->where('status', 'success')
                                    ->sum('nominal2');;
        $saldoAkhirUangKas = $saldoAwalUangKas - $pengeluaranTotalUangKas;

        $availableMonths = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $selectedMonthName = $availableMonths[$selectedMonth] ?? '';

        return view('admin.index', compact(
            'campaign',
            'chartData',
            'selectedMonthName',
            'selectedMonth',
            'selectedYear',
            'selectedCampaign',
            'saldoAwalUangKas',
            'pengeluaranTotalUangKas',
            'saldoAkhirUangKas',
            'totalAlumni',
            'status',
        ));
    }


    public function administrator()
    {
        $data = Administrator::all();
        return view('admin.administrator', compact('data'));

    }

    public function administrator_store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'info' => 'nullable|string',
            'item' => 'required',
        ]);

        $data = [
            'info' => $validatedData['info'],
        ];

        if ($request->hasFile('item')) {
            $foto = $request->file('item');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $fotoPath = $foto->move('images/item', $fotoName);
            $data['item'] = 'images/item/' . $fotoName;
        } else {
            $data['item'] = $validatedData['item'];
        }

        Administrator::create($data);

        return redirect()->back()->with('success', 'Item created successfully.');
    }

    public function administrator_edit(Request $request, $item_id)
    {
        $isText = $this->isTextItem($item_id);
        
        $validatedData = $request->validate([
            'item' => $isText ? 'required|string' : 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [];

        if ($isText) {
            $data['item'] = $validatedData['item'];
        } else {
            if ($request->hasFile('item')) {
                $item = Administrator::where('item_id', $item_id)->first();
                if ($item->item && file_exists($item->item)) {
                    unlink(public_path($item->item));
                }

                $foto = $request->file('item');
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $fotoPath = $foto->move('images/item', $fotoName);
                $data['item'] = 'images/item/' . $fotoName;
            }
        }

        Administrator::where('item_id', $item_id)->update($data);

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    /**
     * Determines if the item should be treated as text or a photo based on item_id.
     */
    private function isTextItem($item_id)
    {
        $textItemIds = [2, 3, 5]; // Example: IDs that should be treated as text
        return in_array($item_id, $textItemIds);
    }


    public function cariorder_id(Request $request)
    {
        $order_id = $request->input('order_id');

        if ($order_id) {
            $donasi = Donasi::where('order_id', 'like', "%{$order_id}%")->get();
        } else {
            $donasi = collect();
        }

        return view('admin.cariorder_id', compact('donasi', 'order_id'))->render();
    }

    public function ubahstatustransaksi(Request $request, $order_id)
    {
        $status = $request->input('status');

        if ($order_id) {
            $donasi = Donasi::where('order_id', $order_id)->first();

            if ($donasi) {
                $donasi->status = $status;
                $donasi->save();

                return redirect()->route('cariorder_id', ['order_id' => $order_id])->with('success', 'Status berhasil diubah.');
            } else {
                return redirect()->back()->with('error', 'Order ID tidak ditemukan.');
            }
        } else {
            return redirect()->back()->with('error', 'Tidak Ada Order ID.');
        }
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




    public function getAlumniData()
    {
        $alumniPerAngkatan = Angkatan::withCount('alumni')->get();

        return response()->json($alumniPerAngkatan);
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

}
