<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'title',
        'type',
    ];

    protected $casts = [
        'type' => 'string',
    ];
    
    public const TYPES = [
        'date',
        'number',
        'string',
        'boolean',
        'link',
    ];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'field_subscriber')
            ->withPivot('value')
            ->withTimestamps();
    }
}
