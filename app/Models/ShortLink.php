<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'shorten_url', 'destination_url'
    ];

    /**
     * Get the perclick associated with the ShortLink
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function perclick(): HasOne
    {
        return $this->hasOne(PerClick::class);
    }

    /**
     * Get all of the PerClick for the ShortLink
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perclicks(): HasMany
    {
        return $this->hasMany(PerClick::class);
    }
}
