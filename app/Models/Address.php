<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep',
        'place',
        'number',
        'neighborhood',
        'city',
        'state',
        'details'
    ];

    // Um Endereço TEM UM Fornecedor (se for 1:1)
    // A chave estrangeira 'address_id' está na tabela 'suppliers'
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'address_id', 'id');
        // 'address_id' é a chave estrangeira na tabela 'suppliers'
        // 'id' é a chave local na tabela 'addresses'
    }
}