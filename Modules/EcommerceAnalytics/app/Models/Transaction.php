<?php

namespace Modules\EcommerceAnalytics\Models;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'ecommerce_transactions';

    protected $fillable = [
        'user_id',
        'business_id',
        'connected_store_id',
        'transaction_type',
        'source',
        'external_id',
        'amount',
        'currency',
        'description',
        'transaction_date',
        'raw_data',
    ];

    protected $casts = [
        'raw_data' => 'array',
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function connectedStore(): BelongsTo
    {
        return $this->belongsTo(ConnectedStore::class);
    }
}
