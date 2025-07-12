<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model
{
    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantidade',
        'prazo_entrega',
        'canal_envio',
        'mensagem_enviada',
    ];

    public function produto()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id');
    }
}
