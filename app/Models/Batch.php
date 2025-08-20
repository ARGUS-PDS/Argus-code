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
}
