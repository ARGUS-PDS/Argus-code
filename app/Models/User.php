<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt; // 👈 Importante para criptografia

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que podem ser preenchidos em massa (mass assignment).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cartao_seg',
        'remember_token',
    ];

    /**
     * Campos que serão ocultos ao serializar o model (ex: JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
        'cartao_seg', 
    ];

    /**
     * Casts automáticos para alguns campos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function setCartaoSegAttribute($value)
{
    // Evita recriptografar se já estiver criptografado
    if (!empty($value)) {
        // Se o valor já for criptografado, não criptografa de novo
        try {
            Crypt::decryptString($value);
            $this->attributes['cartao_seg'] = $value;
        } catch (\Exception $e) {
            $this->attributes['cartao_seg'] = Crypt::encryptString($value);
        }
    }
}

public function getCartaoSegAttribute($value)
{
    // Evita tentar descriptografar valores inválidos (ou nulos)
    if (empty($value)) {
        return null;
    }

    try {
        return Crypt::decryptString($value);
    } catch (\Exception $e) {
        // Retorna o valor original caso não esteja criptografado
        return $value;
    }
}
}