<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory, HasUuids, Sluggable;

    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'destination',
        'number_of_days',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($attributes) => isset($attributes['number_of_days']) ? $attributes['number_of_days'] - 1 : 0
        );
    }

    public function getNumberOfNightsAttribute(): int
    {
        return $this->number_of_days - 1;
    }

    // Route::get('/travels/{travel}/tours', [TourController::class, 'index']);
    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }

}
