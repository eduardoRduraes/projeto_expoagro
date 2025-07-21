<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';
    protected $fillable = [
        'nome',
        'cpf',
        'status',
        'telefone',
        'categoria_cnh',
    ];

    public const STATUS_LIVRE = 'livre';
    public const STATUS_EM_SERVICO = 'em_servico';

    public function usos(): HasMany
    {
        return $this->hasMany(UsoMaquina::class);
    }
}
