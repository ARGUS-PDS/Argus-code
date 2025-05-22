<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'barcode',
        'description',
        'expiration_date',
        'value',
        'profit',
        'supplierId',
        'brand',
        'model',
        'currentStock',
        'minimumStock',
        'status',
        'image_url',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplierId')->withDefault();
    }
}
