<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'travels';
    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'destination',
        'number_of_days',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
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
    
}
