<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FieldSubscriber extends Pivot
{
    protected $table = 'field_subscriber';

    protected $fillable = [
        'subscriber_id',
        'field_id',
        'value',
    ];
    
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
