<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Alumni;
use App\Models\UangKas;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UangKasController2 extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumni = Alumni::get();
        return view('index.uangkas', compact('alumni'));
    }

    public function uangkas(Request $request)
    {
        $angkatan_id = $request->input('angkatan');

        $angkatan = Angkatan::all();

        $query = Uangkas::query();
        
        if ($request->has('angkatan') && $request->angkatan) {
            $query->where('angkatan_id', $request->angkatan);
        }

        $uangkas = $query->get();

        $hasFilters = $angkatan_id;

        if ($uangkas->isEmpty()) {
            return view('admin.uangkas.index', [
                'angkatan' => Angkatan::all(),
                'uangkas' => $uangkas,
                'hasFilters' => $hasFilters,
                'noData' => true,
            ]);
        }

        return view('admin.uangkas.index', [
            'angkatan' => $angkatan,
            'uangkas' => $uangkas,
            'hasFilters' => $hasFilters,
        ]);
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
        $request->validate([
            'alumni_id' => 'required|exists:alumni,id',
            'nominal' => 'required',
        ]);

        $alumni = Alumni::find($request->alumni_id);

        if (!$alumni) {
            return redirect()->back()->with('error', 'Error, Alumni tidak ditemukan.');
        }
            $uangkas = UangKas::create([
                'alumni_id' => $alumni->id,
                'nama' => $alumni->nama,
                'angkatan_id' => $alumni->angkatan_id,
                'nominal' => $request->input('nominal'),
                'status' => 'pending',
            ]);

        $params = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->input('nominal'),
            ],
            'customer_details' => [
                'first_name' => $alumni->nama,
                // 'email' => 'customer@example.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $uangkas->snap_token = $snapToken;
        $uangkas->save();

        
        $encryptedId = Crypt::encrypt($uangkas->id);
        return redirect()->route('payment', $encryptedId);

        // return redirect()->back()->with('success', 'Data has been stored successfully.');
        // return view('index.payment-page', ['snap_token' => $snapToken]);
    }

    public function payment($encryptedId)
    {
        try {
            $decryptedId = Crypt::decrypt($encryptedId);
            $uangkas = UangKas::findOrFail($decryptedId);
            
            return view('index.payment', compact('uangkas'));
        } catch (DecryptException $e) {
            return redirect('/uangkas')->with('error', 'Unauthorized access to payment page.');
        }
    }


    public function updatePaymentStatus(Request $request)
    {
            $uangkas = UangKas::find($request->id);
            
            // Update payment status based on the response
            $uangkas->status = $request->status;
            $uangkas->transaction_result = json_encode($request->transaction_result); // Store the transaction result if needed
            $uangkas->save();

            return response()->json(['message' => 'Payment status updated successfully.']);
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
