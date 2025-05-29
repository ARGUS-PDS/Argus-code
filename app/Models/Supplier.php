<?php

namespace App\Models;

use App\Models\Address; // Importação correta
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'address_id', // Certifique-se de que está aqui para mass assignment
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

    // UM Fornecedor PERTENCE A UM Endereço
    // A chave estrangeira 'address_id' está na tabela 'suppliers'
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
        // 'address_id' é a chave estrangeira na tabela 'suppliers'
        // 'id' é a chave primária na tabela 'addresses'
        // Se você seguiu as convenções do Laravel (address_id e id),
        // pode até simplificar para: return $this->belongsTo(Address::class);
    }
}
