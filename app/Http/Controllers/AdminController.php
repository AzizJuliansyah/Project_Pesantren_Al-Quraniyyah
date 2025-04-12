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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $isAudio = $item_id == 4;

        $validatedData = $request->validate([
            'item' => $isText 
                ? 'required|string' 
                : ($isAudio 
                    ? 'required|mimetypes:audio/mpeg,audio/wav,audio/ogg|max:10240' // Audio max 5MB
                    : 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Gambar max 2MB
                ),
        ]);

        $data = [];

        if ($isText) {
            $data['item'] = $validatedData['item'];
        } elseif ($isAudio || $request->hasFile('item')) {
            // Jika item berupa file (audio atau gambar)
            $item = Administrator::where('item_id', $item_id)->first();
            if ($item && $item->item && file_exists(public_path($item->item))) {
                unlink(public_path($item->item));
            }

            $file = $request->file('item');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->move($isAudio ? 'audio/item' : 'images/item', $fileName);
            $data['item'] = ($isAudio ? 'audio/item/' : 'images/item/') . $fileName;
        }

        Administrator::where('item_id', $item_id)->update($data);

        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    
    private function isTextItem($item_id)
    {
        $textItemIds = [2, 3, 5, 8, 9]; // ID yang harus berupa teks
        return in_array($item_id, $textItemIds);
    }



    public function caritransaksi(Request $request)
    {
        $campaign = Campaign::all();
        $status = $request->input('status');

        $order_id = $request->input('order_id');
        if ($order_id) {
            $donasi = Donasi::where('order_id', 'like', "%{$order_id}%")->get();
        } else {
            $donasi = collect();
        }


        $tahunUangKas = $request->input('tahun');
        if ($tahunUangKas) {
            $selectedCampaign = 1;
            $uangkasQuery = Donasi::where('campaign_id', $selectedCampaign)
                               ->whereYear('created_at', $tahunUangKas);

            if ($status) {
                $uangkasQuery->where('status', $status);
            }

            $uangkas = $uangkasQuery->orderBy('id', 'DESC')->get();
        } else {
            $uangkas = collect();
        }


        $campaign_id = $request->input('campaign_id');
        $namacampaign = "";
        if ($campaign_id) {
            $donasicampaignQuery = Donasi::where('campaign_id', $campaign_id);

            if ($status) {
                $donasicampaignQuery->where('status', $status);
            }

            $donasicampaign = $donasicampaignQuery->orderBy('id', 'DESC')->get();

            $namacampaign = Campaign::where('id', $campaign_id)->first();
        } else {
            $donasicampaign = collect();
        }

        return view('admin.caritransaksi', compact('donasi', 'campaign', 'uangkas', 'donasicampaign', 'namacampaign'))->render();
    }

    public function bulkUpdateStatusOrDelete(Request $request)
    {
        $selectedIds = $request->input('selected_ids', []);

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Tidak ada transaksi yang dipilih.');
        }

        DB::beginTransaction();

        try {
            if ($request->action == 'update_status') {
                $status = $request->input('status');
                if ($status) {
                    foreach ($selectedIds as $id) {
                        Donasi::where('id', $id)->update(['status' => $status]);
                    }
                }
            } elseif ($request->action == 'delete') {
                Donasi::whereIn('id', $selectedIds)->delete();
            }

            DB::commit(); 
            return redirect()->back()->with('success', 'Aksi berhasil dilakukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat melakukan aksi: ' . $e->getMessage());
        }
    }




    

    public function ubahstatustransaksi(Request $request, $order_id)
    {
        $status = $request->input('status');

        if ($order_id) {
            $donasi = Donasi::where('order_id', $order_id)->first();

            if ($donasi) {
                $donasi->status = $status;
                $donasi->save();

                return redirect()->route('caritransaksi', ['order_id' => $order_id])->with('success', 'Status berhasil diubah.');
            } else {
                return redirect()->back()->with('error', 'Order ID tidak ditemukan.');
            }
        } else {
            return redirect()->back()->with('error', 'Tidak Ada Order ID.');
        }
    }

    public function hapustransaksi($order_id)
    {
        if ($order_id) {
            Donasi::where('order_id', $order_id)->delete();

            return redirect()->route('caritransaksi', ['order_id' => $order_id])->with('success', 'Berhasil Menghapus Transaksi.');
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
