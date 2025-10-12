<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    /** 
     * Criptografa o CNPJ apenas se ainda não estiver criptografado
     */
    public function setCnpjAttribute($value)
    {
        if (!empty($value)) {
            try {
                // Se já estiver criptografado, não faz nada
                Crypt::decryptString($value);
                $this->attributes['cnpj'] = $value;
            } catch (\Exception $e) {
                // Criptografa apenas se não for criptografado
                $this->attributes['cnpj'] = Crypt::encryptString($value);
            }
        }
    }

    public function getCnpjAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            // Retorna valor original se não estiver criptografado
            return $value;
        }
    }

    /** 
     * Criptografa a Inscrição Estadual com o mesmo padrão
     */
    public function setStateRegistrationAttribute($value)
    {
        if (!empty($value)) {
            try {
                Crypt::decryptString($value);
                $this->attributes['stateRegistration'] = $value;
            } catch (\Exception $e) {
                $this->attributes['stateRegistration'] = Crypt::encryptString($value);
            }
        }
    }

    public function getStateRegistrationAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'addressId');
    }
}