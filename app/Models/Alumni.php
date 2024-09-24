<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Angkatan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;

    protected $table = "alumni";
    protected $fillable = [
        'nama',
        'slug',
        'no_telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'pendidikan_terakhir',
        'angkatan_id',
        'status_id',
        'usaha',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($alumni) {
            $alumni->slug = Alumni::generateUniqueSlug($alumni->nama);
        });

        static::updating(function ($alumni) {
            if ($alumni->isDirty('nama')) {
                $alumni->slug = Alumni::generateUniqueSlug($alumni->nama);
            }
        });
    }

    public static function generateUniqueSlug($nama)
    {
        $slug = Str::slug($nama);

        $count = Alumni::where('slug', 'like', $slug . '%')->count();

        return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id', 'id'); // 'angkatan' is the foreign key
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id'); // 'status' is the foreign key
    }


    
}
