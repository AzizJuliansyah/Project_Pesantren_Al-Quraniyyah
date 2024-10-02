<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Alumni;
use App\Models\Donasi;
use App\Models\Angkatan;
use App\Models\Campaign;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UangKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
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

        return view('admin.uangkas.index', compact(
            'totalUangKasPerAngkatan',
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

    public function dashboard(Request $request)
    {
        $selectedMonth = $request->input('month', null);
        $selectedYear = $request->input('year', null);
        $selectedCampaign = 1;
        $campaign = Campaign::findOrFail($selectedCampaign);

        $uangkasQuery = Donasi::with('campaign')
        ->where('status', 'success')
        ->where('campaign_id', $selectedCampaign)
            ->whereHas('alumni', function ($query) {
                $query->where('angkatan_id', 5); // Filter untuk angkatan 1
            })
            ->get();


        if ($selectedYear) {
            $uangkasQuery->whereYear('created_at', $selectedYear);
        }

        if ($selectedMonth) {
            $uangkasQuery->whereMonth('created_at', $selectedMonth);
        }

        $uangkas = $uangkasQuery;

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
        $saldoAwalUangKas = Donasi::where('campaign_id', $selectedCampaign)->sum('nominal2');;
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

        return view('admin.uangkas.dashboard', compact('campaign', 'chartData', 'selectedMonthName', 'selectedMonth', 'selectedYear', 'selectedCampaign', 'saldoAwalUangKas', 'pengeluaranTotalUangKas', 'saldoAkhirUangKas'));
    }

    public function detail(Request $request, $angkatan_id)
    {
        $angkatan = Angkatan::findOrFail($angkatan_id);

        $tahun = $request->input('tahun');
        $nama = $request->input('nama');
        $order_id = $request->input('order_id');
        $hasFilters = false;

        $query = Alumni::where('angkatan_id', $angkatan_id);


        $selectedMonth = $request->input('month', null);
        $selectedYear = $request->input('year', null);
        $selectedCampaign = 1;
        $campaign = Campaign::findOrFail($selectedCampaign);
        $uangkasQuery = Donasi::with('campaign')
        ->where('status', 'success')
        ->where('campaign_id', $selectedCampaign)
            ->whereHas('alumni', function ($query) use ($angkatan_id) {
                $query->where('angkatan_id', $angkatan_id);
            })
            ->get();


        if ($nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
            $hasFilters = true;
        }

        $alumni = $query->paginate(25);

        $donasiQuery = Donasi::where('campaign_id', 1)
        ->whereIn('alumni_id', $alumni->pluck('id'));

        if ($tahun) {
            $donasiQuery->whereYear('created_at', '>=', $tahun);
            $hasFilters = true;
        }
        $donasi = $donasiQuery->get();

        $donasiByOrderId = collect();

        // Jika pencarian berdasarkan order_id
        if ($order_id) {
            $donasiByOrderId = $donasiQuery->where('order_id', 'like', '%' . $order_id . '%')->get();
            $hasFilters = true;
        }

        foreach ($alumni as $alum) {
            $alum->donasi = $donasi->where('alumni_id', $alum->id);
        }



        // Filter by year if provided
        if ($selectedYear) {
            $uangkasQuery = $uangkasQuery->filter(function ($donasi) use ($selectedYear) {
                return $donasi->created_at->year == $selectedYear; // Compare year
            });
        }

        // Filter by month if provided
        if ($selectedMonth) {
            $uangkasQuery = $uangkasQuery->filter(function ($donasi) use ($selectedMonth) {
                return $donasi->created_at->month == $selectedMonth; // Compare year
            });
        }

        $uangkas = $uangkasQuery;

        // Initialize totals
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

        // Determine chart type
        $chartType = 'all'; // Default chart type
        if ($request->year && $request->month) {
            $chartType = 'monthInYear';
        } elseif ($request->year) {
            $chartType = 'yearly';
        } elseif ($request->month) {
            $chartType = 'weekly';
        }

        // Prepare chart data
        $chartData = [
            'chartType' => $chartType,
            'monthlyTotals' => $monthlyTotals,
            'weeklyTotals' => $weeklyTotals,
            'persentaseKenaikanBulanan' => $persentaseKenaikanBulanan,
            'persentaseKenaikanMingguan' => $persentaseKenaikanMingguan,
            'total' => $totalUangKas,
            'totalWeekly' => $totalWeekly,
        ];

        // Calculate saldo
        $pengeluaranTotalUangKas = Pengeluaran::sum('nominal');
        $saldoAwalUangKas = Donasi::where('campaign_id', $selectedCampaign)->sum('nominal2');
        $saldoAkhirUangKas = $saldoAwalUangKas - $pengeluaranTotalUangKas;

        // Prepare available months
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

        return view('admin.uangkas.detail', compact(
            'campaign',
            'chartData',
            'donasiByOrderId',
            'selectedMonthName',
            'selectedMonth',
            'selectedYear',
            'selectedCampaign',
            'saldoAwalUangKas',
            'pengeluaranTotalUangKas',
            'saldoAkhirUangKas',
            'donasi',
            'alumni',
            'hasFilters',
            'angkatan',
            'angkatan_id'
        ));
    }




    public function pembayaranuangkas(Request $request)
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

        return view('index.campaign.detailuangkas', compact(
            'totalUangKasPerAngkatan',
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

    public function detailuangkas(Request $request, $angkatan_id)
    {
        $angkatan = Angkatan::findOrFail($angkatan_id);

        $tahun = $request->input('tahun');
        $nama = $request->input('nama');
        $order_id = $request->input('order_id');
        $hasFilters = false;

        $query = Alumni::where('angkatan_id', $angkatan_id);


        $selectedMonth = $request->input('month', null);
        $selectedYear = $request->input('year', null);
        $selectedCampaign = 1;
        $campaign = Campaign::findOrFail($selectedCampaign);
        $uangkasQuery = Donasi::with('campaign')
        ->where('status', 'success')
        ->where('campaign_id', $selectedCampaign)
            ->whereHas('alumni', function ($query) use ($angkatan_id) {
                $query->where('angkatan_id', $angkatan_id);
            })
            ->get();


        if ($nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
            $hasFilters = true;
        }

        $alumni = $query->paginate(25);

        $donasiQuery = Donasi::where('campaign_id', 1)
        ->whereIn('alumni_id', $alumni->pluck('id'));

        if ($tahun) {
            $donasiQuery->whereYear('created_at', '>=', $tahun);
            $hasFilters = true;
        }
        $donasi = $donasiQuery->get();

        $donasiByOrderId = collect();

        if ($order_id) {
            $donasiByOrderId = $donasiQuery->where('order_id', 'like', '%' . $order_id . '%')->get();
            $hasFilters = true;
        }

        foreach ($alumni as $alum) {
            $alum->donasi = $donasi->where('alumni_id', $alum->id);
        }

        if ($selectedYear) {
            $uangkasQuery = $uangkasQuery->filter(function ($donasi) use ($selectedYear) {
                return $donasi->created_at->year == $selectedYear;
            });
        }
        if ($selectedMonth) {
            $uangkasQuery = $uangkasQuery->filter(function ($donasi) use ($selectedMonth) {
                return $donasi->created_at->month == $selectedMonth; 
            });
        }

        $uangkas = $uangkasQuery;

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

        $chartType = 'all';
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
        $saldoAwalUangKas = Donasi::where('campaign_id', $selectedCampaign)->sum('nominal2');
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

        return view('index.campaign.detailuangkasangkatan', compact(
            'campaign',
            'chartData',
            'donasiByOrderId',
            'selectedMonthName',
            'selectedMonth',
            'selectedYear',
            'selectedCampaign',
            'saldoAwalUangKas',
            'pengeluaranTotalUangKas',
            'saldoAkhirUangKas',
            'donasi',
            'alumni',
            'hasFilters',
            'angkatan',
            'angkatan_id'
        ));
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
