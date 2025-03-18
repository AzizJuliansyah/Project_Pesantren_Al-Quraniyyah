<?php

namespace App\Models;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Angkatan extends Model
{
    use HasFactory;

    protected $table = "angkatan";
    protected $fillable = [
        'angkatan',
        'info',
    ];

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'angkatan_id');
    }

    

}
