<?php

namespace App\Models;

use App\Models\Donasi;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $table = "campaign";
    protected $fillable = [
        'campaign_id',
        'nama',
        'info',
        'server_key',
        'client_key',
        'target',
        'nominal',
        'foto',
        'video',
        'tampilkan_video',
        'publish',
        'pilihan',
    ];

    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'id', 'campaign_id'); // 'angkatan' is the foreign key
    }

    public function getTotalDonasiAttribute()
    {
        return $this->donasi()->where('status', 'success')->sum('nominal2');
    }


    public function getDonaturAttribute()
    {
        return $this->donasi()
            ->where('status', 'success')
            ->pluck('nama')
            ->unique()
            ->take(3);
    }

    public function getTotalDonaturAttribute()
    {
        return $this->donasi()
            ->where('status', 'success')
            ->pluck('nama')
            ->unique()
            ->count();
    }

    public function getPersenDonasiAttribute()
    {
        if ($this->target > 0) {
            return round(($this->total_donasi / $this->target) * 100, 2);
        }
        return 0;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($campaign) {
            $campaign->slug = Campaign::generateUniqueSlug($campaign->nama);
        });

        static::updating(function ($campaign) {
            if ($campaign->isDirty('nama')) {
                $campaign->slug = Campaign::generateUniqueSlug($campaign->nama);
            }
        });
    }

    public static function generateUniqueSlug($nama)
    {
        $slug = Str::slug($nama);

        $count = Campaign::where('slug', 'like', $slug . '%')->count();

        return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
    }
}
