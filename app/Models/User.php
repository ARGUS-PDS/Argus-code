<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cnpj',
        'cartao_seg',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'cartao_seg',
        'cnpj',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔐 Criptografia automática do CNPJ
    protected function cnpj(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $this->encryptValue($value),
            get: fn($value) => $this->decryptValue($value)
        );
    }

    //  Criptografia automática do código do cartão
    protected function cartaoSeg(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $this->encryptValue($value),
            get: fn($value) => $this->decryptValue($value)
        );
    }

    //  Funções auxiliares reutilizáveis
    private function encryptValue($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Evita recriptografar se já estiver cifrado
            Crypt::decryptString($value);
            return $value;
        } catch (\Exception $e) {
            return Crypt::encryptString($value);
        }
    }

    private function decryptValue($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // Retorna original se não estiver criptografado
        }
    }
}