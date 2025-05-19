<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'supplier_id',
        'cep',
        'place',
        'number',
        'neighborhood',
        'city',
        'state'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
