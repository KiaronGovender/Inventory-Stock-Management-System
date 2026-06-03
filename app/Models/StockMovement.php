<?php

namespace App\Models;

use Database\Factories\StockMovementFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    /** @use HasFactory<StockMovementFactory> */
    use HasFactory;

    public const TYPE_IN = 'in';
    public const TYPE_OUT = 'out';

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'unit_cost',
        'reason',
        'reference',
        'notes',
        'moved_at',
    ];

    protected function casts(): array
    {
        return [
            'moved_at' => 'datetime',
            'quantity' => 'integer',
            'stock_before' => 'integer',
            'stock_after' => 'integer',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeType(Builder $query, ?string $type): Builder
    {
        return $query->when($type, fn (Builder $query): Builder => $query->where('type', $type));
    }

    public function scopeProduct(Builder $query, ?int $productId): Builder
    {
        return $query->when($productId, fn (Builder $query): Builder => $query->where('product_id', $productId));
    }
}
