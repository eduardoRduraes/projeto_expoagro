<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';
    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'cnh',
    ];

    public function usos()
    {
        return $this->hasMany(UsoMaquina::class);
    }
}
