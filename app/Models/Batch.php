<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batch';

    protected $fillable = [
        'batch_code',
        'expiration_date',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'batch_id');
    }
}
