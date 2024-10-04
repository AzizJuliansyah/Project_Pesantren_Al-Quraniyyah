<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Carbon\Carbon;
use Midtrans\Snap;
use App\Models\Alumni;
use App\Models\Donasi;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CampaignPaymentController extends Controller
{
    public function daftarcampaign()
    {
        $campaign = Campaign::where('publish', 1)
            ->orderByRaw('id = 1 DESC, id DESC')
            ->get();

        $heading = Administrator::where('item_id', 2)->first();
        $subheading = Administrator::where('item_id', 3)->first();

        return view('index.campaign.daftarcampaign', compact('campaign', 'heading', 'subheading'));
    }



    public function show(string $slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        $alumni = Alumni::all();

        if ($campaign->publish == 0) {
            return redirect()->route('home')->with('error', 'Maaf, Campaign Sedang Tidak Bisa Diakses');
        }

        return view('index.campaign.show', compact('campaign', 'alumni'));
    }

    public function uangkas(Request $request)
    {
        $slug = "uang-kas";
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        $campaign_id = $campaign->id;

        $totalDonasi = Donasi::where('campaign_id', $campaign_id)
            ->where('status', 'success')
            ->sum('nominal2');

        $percentage = ($campaign->target > 0) ? ($totalDonasi / $campaign->target) * 100 : 0;

        $selectedMonth = $request->input('month', null);

        $donasiQuery = Donasi::with('campaign')
            ->where('status', 'success')
            ->where('campaign_id', $campaign_id);

        if ($selectedMonth) {
            $donasiQuery->whereMonth('created_at', $selectedMonth);
        }

        $donasi = $donasiQuery->orderBy('id', 'DESC')->get();

        $monthlyTotals = array_fill(0, 12, 0);
        $weeklyTotals = array_fill(0, 4, 0);
        $totalDonasi = 0;

        // Hitung total bulanan dan mingguan
        foreach ($donasi as $d) {
            $month = (int) Carbon::parse($d->created_at)->format('m') - 1;
            $monthlyTotals[$month] += floatval($d->nominal2);
            $totalDonasi += floatval($d->nominal2);

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


        $chartType = 'monthly'; // Default chart type

        if ($request->month) {
            $chartType = 'weekly';
        }

        $chartData = [
            'chartType' => $chartType,
            'monthlyTotals' => $monthlyTotals,
            'weeklyTotals' => $weeklyTotals,
            'persentaseKenaikanBulanan' => $persentaseKenaikanBulanan,
            'persentaseKenaikanMingguan' => $persentaseKenaikanMingguan,
            'total' => $totalDonasi,
            'totalWeekly' => $totalWeekly,
        ];


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

        return view('index.campaign.detail', compact(
            'campaign',
            'chartData',
            'selectedMonthName',
            'selectedMonth',
            'campaign_id',
            'campaign',
            'totalDonasi',
            'percentage',
            'campaign_id',
            'slug'
        ));
    }


    public function detail(Request $request, string $slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        if ($campaign->publish == 0) {
            return redirect()->route('home')->with('error', 'Maaf, Campaign Sedang Tidak Bisa Diakses');
        }
        
        $campaign_id = $campaign->id;

        $totalDonasi = Donasi::where('campaign_id', $campaign_id)
            ->where('status', 'success')
            ->sum('nominal2');

        $percentage = ($campaign->target > 0) ? ($totalDonasi / $campaign->target) * 100 : 0;

        $selectedMonth = $request->input('month', null);

        $donasiQuery = Donasi::with('campaign')
            ->where('status', 'success')
            ->where('campaign_id', $campaign_id);

        if ($selectedMonth) {
            $donasiQuery->whereMonth('created_at', $selectedMonth);
        }

        $donasi = $donasiQuery->orderBy('id', 'DESC')->get();

        $monthlyTotals = array_fill(0, 12, 0);
        $weeklyTotals = array_fill(0, 4, 0);
        $totalDonasi = 0;

        // Hitung total bulanan dan mingguan
        foreach ($donasi as $d) {
            $month = (int) Carbon::parse($d->created_at)->format('m') - 1;
            $monthlyTotals[$month] += floatval($d->nominal2);
            $totalDonasi += floatval($d->nominal2);

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


        $chartType = 'monthly'; // Default chart type

        if ($request->month) {
            $chartType = 'weekly';
        }

        $chartData = [
            'chartType' => $chartType,
            'monthlyTotals' => $monthlyTotals,
            'weeklyTotals' => $weeklyTotals,
            'persentaseKenaikanBulanan' => $persentaseKenaikanBulanan,
            'persentaseKenaikanMingguan' => $persentaseKenaikanMingguan,
            'total' => $totalDonasi,
            'totalWeekly' => $totalWeekly,
        ];


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

        return view('index.campaign.detail', compact(
            'campaign',
            'chartData',
            'selectedMonthName',
            'selectedMonth',
            'campaign_id',
            'campaign',
            'totalDonasi',
            'percentage',
            'campaign_id',
            'slug'
        ));
    }




    public function donasi(Request $request)
    {
        try {
            $campaign_id = decrypt($request->campaign_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Campaign ID tidak valid.');
        }

        $campaign = Campaign::find($campaign_id);
        if (!$campaign) {
            return redirect()->back()->with('error', 'Error, campaign tidak ditemukan.');
        }

        if ($campaign_id == 1) {
            $request->validate([
                'alumni_id' => 'required|exists:alumni,id',
                'angkatan_id' => 'required|exists:angkatan,id',
                'nominal' => 'required|numeric',
            ], [
                'alumni_id.required' => 'Data Alumni Harus Diisi!',
                'angkatan_id.required' => 'Angkatan Harus Diisi!',
                'nominal.required' => 'Nominal Harus Diisi!',
                'nominal.numeric' => 'Nominal Harus Diisi dengan format angka!',
            ]);

            $alumni = Alumni::find($request->alumni_id);
            if (!$alumni) {
                return redirect()->back()->with('error', 'Error, Alumni tidak ditemukan.');
            }
        } else {
            $request->validate([
                'nama' => 'required|string',
                'nominal' => 'required|numeric',
            ], [
                'nama.required' => 'Nama Harus Diisi!',
                'nominal.required' => 'Nominal Harus Diisi!',
                'nominal.numeric' => 'Nominal Harus Diisi dengan format angka!',
            ]);

            $alumni = Alumni::where('nama', $request->nama)->first();
            if (!$alumni) {
                $alumni = new Alumni();
                $alumni->nama = $request->nama;
            }
        }

        $cleanNominal = str_replace('.', '', $request->input('nominal'));
        $nominal = $cleanNominal + $campaign->campaign_id;
        $nominalAfter2Percent = $nominal * 0.02;
        $finalNominal = $nominal - $nominalAfter2Percent;

        $orderId = uniqid();

        $donasi = Donasi::create([
            'alumni_id' => $alumni->id ?? null,
            'campaign_id' => $campaign->id,
            'nama' => $alumni->nama,
            'nominal' => $nominal,
            'nominal2' => $finalNominal,
            'status' => 'pending',
            'order_id' => $orderId,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $nominal,
            ],
            'customer_details' => [
                'first_name' => $alumni->nama,
            ],
        ];

        \Midtrans\Config::$serverKey = $campaign->server_key;
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $donasi->snap_token = $snapToken;
        $donasi->save();

        $encryptedId = Crypt::encrypt($donasi->id);

        $request->session()->put('can_access_payment', true);

        return redirect()->route('donasi.payment', $encryptedId);
    }



    public function payment($encryptedId, Request $request)
    {
        if (!$request->session()->has('can_access_payment')) {
            return redirect('/')->with('error', 'Unauthorized access to payment page.');
        }

        try {
            $decryptedId = Crypt::decrypt($encryptedId);
            $donasi = Donasi::findOrFail($decryptedId);

            $campaign = Campaign::findOrFail($donasi->campaign_id);

            return view('index.campaign.payment', compact('donasi', 'campaign'));
        } catch (DecryptException $e) {
            return redirect('/')->with('error', 'Unauthorized access to payment page.');
        }
    }



    public function updateDonationStatus(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');

        $donasi = Donasi::where('order_id', $orderId)->first();
        $campaign = Campaign::findOrFail($donasi->campaign_id);

        if (!$donasi) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

        if ($statusCode == '200' && $transactionStatus == 'settlement') {
            $donasi->status = 'success';
            $donasi->save();

            $request->session()->forget('can_access_payment');
            return view('index.campaign.payment-success', compact('donasi', 'campaign'));

        } elseif ($statusCode == '201' && $transactionStatus == 'pending') {
            $donasi->status = 'pending';
            $donasi->save();

            $request->session()->forget('can_access_payment');
            return view('index.campaign.payment-pending', compact('donasi', 'campaign'));

        } elseif ($statusCode == '202' || in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $donasi->status = 'error';
            $donasi->save();

            $request->session()->forget('can_access_payment');
            return view('index.campaign.payment-pending', compact('donasi', 'campaign'));
            
        } else {
            // Jika status tidak dikenali
            return response()->json(['message' => 'Invalid transaction status'], 400);
        }
    }


    public function payment_success($encryptedId, Request $request)
    {
        if (!$request->session()->has('can_access_payment')) {
            return redirect('/')->with('error', 'Transaksi telah selesai.');
        }

        try {
            $decryptedId = Crypt::decrypt($encryptedId);
            $donasi = Donasi::findOrFail($decryptedId);
            $campaign = Campaign::findOrFail($donasi->campaign_id);

            \Midtrans\Config::$serverKey = $donasi->campaign->server_key;
            \Midtrans\Config::$isProduction = false;

            try {
                $status = \Midtrans\Transaction::status($donasi->order_id);

                if ($status) {
                    if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                        $donasi->status = 'success';
                        $donasi->save();

                        $request->session()->forget('can_access_payment');
                        return view('index.campaign.payment-success', compact('donasi', 'campaign'));
                    } else {
                        $request->session()->forget('can_access_payment');
                        return redirect('/')->with('error', 'Pembayaran belum selesai atau gagal.');
                    }
                } else {
                    $request->session()->forget('can_access_payment');
                    return redirect('/')->with('error', 'Transaksi tidak ditemukan di Midtrans.');
                }
            } catch (\Exception $e) {
                $request->session()->forget('can_access_payment');
                return redirect('/')->with('error', 'Gagal mendapatkan status transaksi. Silakan coba lagi.');
            }
        } catch (DecryptException $e) {
            $request->session()->forget('can_access_payment');
            return redirect('/')->with('error', 'Transaksi telah selesai.');
        }
    }


    public function payment_pending($encryptedId, Request $request)
    {
        if (!$request->session()->has('can_access_payment')) {
            return redirect('/')->with('error', 'Transaksi telah selesai.');
        }

        try {
            $decryptedId = Crypt::decrypt($encryptedId);
            $donasi = Donasi::findOrFail($decryptedId);
            $campaign = Campaign::findOrFail($donasi->campaign_id);

            \Midtrans\Config::$serverKey = $donasi->campaign->server_key;
            \Midtrans\Config::$isProduction = false;

            try {
                $status = \Midtrans\Transaction::status($donasi->order_id);

                if ($status) {
                    if ($status->transaction_status == 'pending') {
                        $donasi->status = 'pending';
                        $donasi->save();

                        $request->session()->forget('can_access_payment');
                        return view('index.campaign.payment-pending', compact('donasi', 'campaign'));
                    } else {
                        $request->session()->forget('can_access_payment');
                        return redirect('/')->with('error', 'Pembayaran belum selesai atau gagal.');
                    }
                } else {
                    $request->session()->forget('can_access_payment');
                    return redirect('/')->with('error', 'Transaksi tidak ditemukan di Midtrans.');
                }
            } catch (\Exception $e) {
                $request->session()->forget('can_access_payment');
                return redirect('/')->with('error', 'Gagal mendapatkan status transaksi. Silakan coba lagi.');
            }
        } catch (DecryptException $e) {
            $request->session()->forget('can_access_payment');
            return redirect('/')->with('error', 'Transaksi telah selesai.');
        }
    }


    public function payment_error($encryptedId, Request $request)
    {
        if (!$request->session()->has('can_access_payment')) {
            return redirect('/')->with('error', 'Transaksi telah selesai.');
        }

        try {
            $decryptedId = Crypt::decrypt($encryptedId);
            $donasi = Donasi::findOrFail($decryptedId);
            $campaign = Campaign::findOrFail($donasi->campaign_id);

            \Midtrans\Config::$serverKey = $donasi->campaign->server_key;
            \Midtrans\Config::$isProduction = false;

            try {
                $status = \Midtrans\Transaction::status($donasi->order_id);

                if ($status) {
                    if ($status->transaction_status == 'deny' || $status->transaction_status == 'expire' || $status->transaction_status == 'cancel') {
                        $donasi->status = 'error';
                        $donasi->save();

                        $request->session()->forget('can_access_payment', compact('donasi', 'campaign'));
                        return view('index.campaign.payment-error');
                    } else {
                        $request->session()->forget('can_access_payment');
                        return redirect('/')->with('error', 'Pembayaran belum selesai atau gagal.');
                    }
                } else {
                    $request->session()->forget('can_access_payment');
                    return redirect('/')->with('error', 'Transaksi tidak ditemukan di Midtrans.');
                }
            } catch (\Exception $e) {
                $request->session()->forget('can_access_payment');
                return redirect('/')->with('error', 'Gagal mendapatkan status transaksi. Silakan coba lagi.');
            }
        } catch (DecryptException $e) {
            $request->session()->forget('can_access_payment');
            return redirect('/')->with('error', 'Transaksi telah selesai.');
        }
    }
}
