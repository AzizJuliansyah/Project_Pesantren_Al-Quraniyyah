<?php

namespace App\Models;

use App\Models\Alumni;
use App\Models\Angkatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UangKas extends Model
{
    use HasFactory;

    protected $table = "uangkas";
    protected $fillable = [
        'alumni_id',
        'nominal',
        'status',
        'snap_token',
        'transaction_result',
    ];

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id', 'id'); // 'angkatan' is the foreign key
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id', 'id'); // 'angkatan' is the foreign key
    }
}
