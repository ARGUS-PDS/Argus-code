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
    public function movements()
    {
        return $this->hasMany(\App\Models\Movement::class, 'product_id');
    }

    public function getCurrentStockAttribute()
    {
        $entradas = $this->movements()->where('type', 'inward')->sum('quantity');
        $saidas = $this->movements()->where('type', 'outward')->sum('quantity');

        return $entradas - $saidas;
    }
}
