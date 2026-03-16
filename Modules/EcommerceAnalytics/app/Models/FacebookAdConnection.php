<?php

namespace Modules\EcommerceAnalytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacebookAdConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_account_id',
        'access_token',
        'facebook_ad_account_id',
        'facebook_business_id',
        'token_expires_at',
        'permissions',
        'account_info',
    ];

    protected $casts = [
        'permissions' => 'array',
        'account_info' => 'array',
        'token_expires_at' => 'datetime',
    ];

    protected $hidden = [
        'access_token',
    ];

    public function adAccount(): BelongsTo
    {
        return $this->belongsTo(AdAccount::class);
    }
}
