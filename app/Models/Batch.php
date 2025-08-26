<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';

    protected $fillable = [
        'batch_code',
        'expiration_date',
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
    public function product()
    {
        return $this->hasOneThrough(
            Product::class,
            Movement::class,
            'batch_id',   // foreign key em movements
            'id',         // foreign key em products
            'id',         // local key em batches
            'product_id'  // local key em movements
        );
    }
}
