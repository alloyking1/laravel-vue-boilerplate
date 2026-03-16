<?php

namespace Modules\EcommerceAnalytics\Models;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'platform',
        'account_name',
        'platform_account_id',
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

    public function facebookAdConnection(): HasOne
    {
        return $this->hasOne(FacebookAdConnection::class);
    }
}
