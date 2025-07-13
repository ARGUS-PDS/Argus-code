<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company'; 

    protected $primaryKey = 'companyId'; 

    public $timestamps = false; 

    protected $fillable = [
        'cnpj',
        'businessName',
        'tradeName',
        'stateRegistration',
        'addressId',
        'user_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'addressId');
    }
}
