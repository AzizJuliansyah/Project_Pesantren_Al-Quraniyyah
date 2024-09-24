<?php

namespace App\Models;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
    protected $table = "status";
    protected $fillable = [
        'status',
        'info',
    ];

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'status_id');
    }

}
