<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Donasi;
use App\Models\Angkatan;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Campaign::query();

        if ($request->filled('dari') && $request->filled('hingga')) {
            $dari = $request->input('dari');
            $hingga = $request->input('hingga');

            if ($dari && $hingga && $dari <= $hingga) {
                $query->whereBetween('created_at', [$dari, $hingga]);
            }
        }

        if ($request->filled('nama')) {
            $nama = $request->input('nama');
            $query->where('nama', 'like', '%' . $nama . '%');
        }

        if ($request->filled('campaign_id')) {
            $campaignId = $request->input('campaign_id');
            $query->where('campaign_id', 'like', '%' . $campaignId . '%');
        }

        $campaign = $query->get();

        return view('admin.campaign.index', [
            'campaign' => $campaign,
            'hasFilters' => $request->hasAny(['dari', 'hingga', 'nama', 'campaign_id']),
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.campaign.tambahcampaign');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|numeric|unique:campaign,campaign_id',
            'nama' => 'required|string|max:255',
            'info' => 'required|string',
            'server_key' => 'required|string',
            'client_key' => 'required|string',
            'target' => 'required|numeric',
            'nominal' => 'nullable|array',
            'nominal.*' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validate the foto input
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'campaign_id' => $request->input('campaign_id'),
            'info' => $request->input('info'),
            'server_key' => $request->input('server_key'),
            'client_key' => $request->input('client_key'),
            'target' => $request->input('target'),
            'nominal' => $request->input('nominal') ? json_encode($request->input('nominal')) : null,
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('campaign_thumbnail', 'public');
            $data['foto'] = $fotoPath;
        }

        Campaign::create($data);


        if ($request->input('action') === 'save_add') {
            return redirect()->route('campaign.create')->with('success', 'Data campaign berhasil disimpan! Silahkan tambah data lagi.');
        } elseif ($request->input('action') === 'save') {
            return redirect()->route('campaign.index')->with('success', 'Data campaign berhasil disimpan!');
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedCampaign = $request->input('campaign_id');

        $donasi = Donasi::with('campaign')
                        ->where('status', 'success')
                        ->where('campaign_id', '!=', 1) // Exclude campaign_id = 1
                        ->orderBy('id', 'DESC')
                        // ->whereYear('created_at', Carbon::now()->year)
                        ->get();

        $groupedDonasi = $donasi->groupBy('campaign_id');

        $chartData = [];
        foreach ($groupedDonasi as $campaignId => $donasi) {
            $monthlyTotals = array_fill(0, 12, 0);
            $weeklyTotals = array_fill(0, 4, 0);
            $totalDonasi = 0;

            foreach ($donasi as $d) {
                $month = (int) Carbon::parse($d->created_at)->format('m') - 1;
                $monthlyTotals[$month] += floatval($d->nominal2);
                $totalDonasi += floatval($d->nominal2);

                if ($campaignId == $selectedCampaign && $month + 1 == $selectedMonth) {
                    $week = Carbon::parse($d->created_at)->weekOfMonth - 1;
                    $weeklyTotals[$week] += floatval($d->nominal2);
                }
            }

            // Menghitung persentase kenaikan bulanan
            $currentMonthIndex = Carbon::now()->format('m') - 1;
            $previousMonthIndex = ($currentMonthIndex > 0) ? $currentMonthIndex - 1 : 11;

            $bulanSebelumnya = $monthlyTotals[$previousMonthIndex];
            $bulanIni = $monthlyTotals[$currentMonthIndex];

            if ($bulanSebelumnya == 0) {
                $persentaseKenaikanBulanan = ($bulanIni > 0) ? 100 : 0;
            } else {
                $persentaseKenaikanBulanan = (($bulanIni - $bulanSebelumnya) / $bulanSebelumnya) * 100;
            }

            // Menghitung total dan persentase untuk mingguan
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



            $chartData[$campaignId] = [
                'chartType' => ($campaignId == $selectedCampaign) ? 'weekly' : 'monthly',
                'monthlyTotals' => $monthlyTotals,
                'weeklyTotals' => $weeklyTotals,
                'persentaseKenaikanBulanan' => $persentaseKenaikanBulanan,
                'persentaseKenaikanMingguan' => $persentaseKenaikanMingguan,
                'total' => $totalDonasi,
                'totalWeekly' => $totalWeekly,
                'nama' => $donasi->first()->campaign->nama,
            ];
        }

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

        return view('admin.campaign.datacampaign', compact('chartData', 'selectedMonthName', 'selectedMonth', 'selectedCampaign'));
    }


    public function detaildatacampaign($encryptedCampaignId, Request $request)
    {
        $decryptedCampaignId = Crypt::decrypt($encryptedCampaignId);
        $campaign = Campaign::findOrFail($decryptedCampaignId);

        $query = Donasi::where('campaign_id', $decryptedCampaignId);

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
            $query->where('nama', 'like', '%' . $request->nama . '%');
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

        return view('admin.campaign.detaildatacampaign', [
            'donasi' => $donasi,
            'hasFilters' => $hasFilters,
            'campaign' => $campaign,
            'angkatan' => $angkatan,
        ]);

    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $campaign = Campaign::where('slug', $slug)->first();
        if (!$campaign) {
            return redirect()->back()->with('error', 'campaign not found');
        }

        return view('admin.campaign.editcampaign', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'info' => 'required|string',
            'server_key' => 'required|string',
            'client_key' => 'required|string',
            'target' => 'required|numeric',
            'nominal' => 'nullable|array',
            'nominal.*' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $campaign = Campaign::findOrFail($id);

        $data = [
            'nama' => $request->input('nama'),
            'campaign_id' => $request->input('campaign_id'),
            'info' => $request->input('info'),
            'server_key' => $request->input('server_key'),
            'client_key' => $request->input('client_key'),
            'target' => $request->input('target'),
            'nominal' => $request->input('nominal') ? json_encode($request->input('nominal')) : null,
        ];

        if ($request->hasFile('foto')) {
            if ($campaign->foto && Storage::disk('public')->exists($campaign->foto)) {
                Storage::disk('public')->delete($campaign->foto);
            }

            $foto = $request->file('foto');
            $fotoPath = $foto->store('campaign_thumbnail', 'public');
            $data['foto'] = $fotoPath;
        }

        $campaign->update($data);

        return redirect()->route('campaign.index')->with('success', 'Berhasil mengubah data campaign');
    }

    public function updatePublishStatus(Request $request, $id)
    {
        $item = Campaign::find($id);
        $item->publish = $request->input('publish');
        $item->save();

        return response()->json(['success' => true]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $campaign = Campaign::findOrFail($id);

            if ($id == 1) {
                return redirect()->route('campaign.index')->with('error', 'Uangkas Tidak Bisa di Hapus!');
            }

            if ($campaign->foto && Storage::disk('public')->exists($campaign->foto)) {
                Storage::disk('public')->delete($campaign->foto);
            }

            Donasi::where('campaign_id', $campaign->id)->delete();

            $campaign->delete();

            DB::commit();

            return redirect()->route('campaign.index')->with('success', 'Campaign dan donasi terkait berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('campaign.index')->with('error', 'Gagal menghapus campaign, donasi tidak dihapus.');
        }
    }


}
