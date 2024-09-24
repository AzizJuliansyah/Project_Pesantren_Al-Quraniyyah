<?php

namespace App\Models;

use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donasi extends Model
{
    use HasFactory;
    protected $table = "donasi";
    protected $fillable = [
        'order_id',
        'campaign_id',
        'alumni_id',
        'nama',
        'nominal',
        'nominal2',
        'status',
        'snap_token',
        'transaction_result',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id'); // 'angkatan' is the foreign key
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id', 'id'); // 'angkatan' is the foreign key
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id', 'id')->with('angkatan');
    }

}
