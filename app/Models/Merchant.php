<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false; // Indicates if the model's ID is auto-incrementing.
    protected $fillable = [
        'code',
        'name'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    /**
     * Get the outlets of the merchant.
     */
    public function outlets(): HasMany
    {
        return $this->hasMany(Outlet::class);
    }

    /**
     * Get the transactions of the merchant.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
