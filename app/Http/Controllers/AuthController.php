<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Donasi;
use App\Models\Angkatan;
use App\Models\Campaign;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     *
     * @return \Illuminate\View\View
     */

    public function home(Request $request)
    {
        $selectedYear = $request->input('year', null);
        $selectedMonth = $request->input('month', null);

        $angkatan = Angkatan::with(['alumni.donasi' => function ($query) use ($selectedYear, $selectedMonth) {
            $query->where('status', 'success')
            ->where('campaign_id', 1);

            if ($selectedYear) {
                $query->whereYear('created_at', $selectedYear);
            }
            if ($selectedMonth) {
                $query->whereMonth('created_at', $selectedMonth);
            }
        }])->get();

        $totalUangKasPerAngkatan = $angkatan->map(function ($angkatan) {
            $totalUangKas = $angkatan->alumni->reduce(function ($carry, $alumni) {
                return $carry + $alumni->donasi->sum('nominal2');
            }, 0);

            return [
                'angkatan' => $angkatan->angkatan,
                'angkatan_id' => $angkatan->id,
                'totalUangKas' => $totalUangKas
            ];
        });

        $totalDonasiPerCampaign = Donasi::select('campaign_id', DB::raw('SUM(nominal2) as total_nominal'))
                        ->groupBy('campaign_id')
                        ->with('campaign')
                        ->get();


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

        return view('index.index', compact(
            'totalUangKasPerAngkatan',
            'totalDonasiPerCampaign',
            'campaign',
            'chartData',
            'selectedMonthName',
            'selectedMonth',
            'selectedYear',
            'selectedCampaign',
            'saldoAwalUangKas',
            'pengeluaranTotalUangKas',
            'saldoAkhirUangKas',
        ));
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('admin.index')->with('success', 'Login berhasil!');

        }

        return back()->with([
            'error' => 'Email atau password salah.',
        ])->onlyInput('email');
    }




    /**
     * Logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
