<?php

namespace App\Models;

use App\Services\CurrencyService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CurrencyRateNotFoundException;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    protected function priceEur(): Attribute
    {
        try {
            //code...
            return Attribute::make(
                get: fn () => (new CurrencyService())->convert($this->price, 'usd', 'eur'),
            );
        } catch (CurrencyRateNotFoundException $e) {
            return 0;
        }
    }

    public function price(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
        );
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
