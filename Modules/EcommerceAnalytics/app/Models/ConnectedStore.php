<?php

namespace Modules\EcommerceAnalytics\Models;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConnectedStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'platform',
        'store_name',
        'store_url',
        'connection_status',
        'last_synced_at',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'last_synced_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function shopifyConnection(): HasOne
    {
        return $this->hasOne(ShopifyConnection::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
