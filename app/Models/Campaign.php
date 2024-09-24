<?php

namespace App\Models;

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
        'publish',
    ];


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
