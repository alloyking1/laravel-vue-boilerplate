<?php

namespace Modules\EcommerceAnalytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopifyConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'connected_store_id',
        'shop_domain',
        'access_token',
        'shopify_store_id',
        'scopes',
        'token_expires_at',
        'shop_info',
    ];

    protected $casts = [
        'scopes' => 'array',
        'shop_info' => 'array',
        'token_expires_at' => 'datetime',
    ];

    protected $hidden = [
        'access_token',
    ];

    public function connectedStore(): BelongsTo
    {
        return $this->belongsTo(ConnectedStore::class);
    }
}
