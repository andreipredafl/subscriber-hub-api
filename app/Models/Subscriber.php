<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'state',
    ];

    protected $casts = [
        'state' => 'string',
    ];
    
    public const STATES = [
        'active',
        'unsubscribed',
        'junk',
        'bounced',
        'unconfirmed',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'field_subscriber')
            ->withPivot('value')
            ->withTimestamps();
    }
}
