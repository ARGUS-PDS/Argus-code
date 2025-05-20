<?php

namespace App\Models;

use App\Models\Address;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'type',
        'document',
        'code',
        'distributor',
        'fixedphone',
        'phone',
        'email',
        'contactNumber1',
        'contactName1',
        'contactPosition1',
        'contactNumber2',
        'contactName2',
        'contactPosition2'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
