<?php

namespace App\Http\Controllers;

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

        return view('index.campaign.daftarcampaign', compact('campaign'));
    }



    public function show(string $slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        $alumni = Alumni::all();
        return view('index.campaign.show', compact('campaign', 'alumni'));
    }

    public function detail(string $slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        $donasi = Donasi::all();
        return view('index.campaign.detail', compact('campaign', 'donasi'));
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

        // Clean up the nominal value
        $cleanNominal = str_replace('.', '', $request->input('nominal'));
        $nominalAfter2Percent = $cleanNominal * 0.02;
        $finalNominal = $cleanNominal - $nominalAfter2Percent;

        // Create order ID
        $orderId = uniqid();

        // Create new donation entry
        $donasi = Donasi::create([
            'alumni_id' => $alumni->id ?? null, // May be null for non-alumni campaigns
            'campaign_id' => $campaign->id,
            'nama' => $alumni->nama,
            'nominal' => $cleanNominal,
            'nominal2' => $finalNominal,
            'status' => 'pending',
            'order_id' => $orderId,
        ]);

        // Midtrans payment params
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $cleanNominal,
            ],
            'customer_details' => [
                'first_name' => $alumni->nama,
            ],
        ];

        // Midtrans configuration
        \Midtrans\Config::$serverKey = $campaign->server_key;
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Generate Snap token
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $donasi->snap_token = $snapToken;
        $donasi->save();

        // Encrypt donation ID
        $encryptedId = Crypt::encrypt($donasi->id);

        // Store session for payment access
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

            \Midtrans\Config::$serverKey = $donasi->campaign->server_key;
            \Midtrans\Config::$isProduction = false;

            try {
                $status = \Midtrans\Transaction::status($donasi->order_id);
                
                if ($status) {
                    if ($status->transaction_status == 'pending') {
                        $donasi->status = 'pending';
                        $donasi->save();

                        $request->session()->forget('can_access_payment');
                        return view('index.campaign.payment-pending');
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

            \Midtrans\Config::$serverKey = $donasi->campaign->server_key;
            \Midtrans\Config::$isProduction = false;

            try {
                $status = \Midtrans\Transaction::status($donasi->order_id);
                
                if ($status) {
                    if ($status->transaction_status == 'deny' || $status->transaction_status == 'expire' || $status->transaction_status == 'cancel') {
                        $donasi->status = 'error';
                        $donasi->save();

                        $request->session()->forget('can_access_payment');
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
