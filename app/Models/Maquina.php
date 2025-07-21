<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maquina extends Model
{
    use HasFactory;

    protected $table = 'maquinas';
    protected $fillable = [
        'nome',
        'modelo',
        'numero_serie',
        'tipo',
        'ano',
        'horas_totais',
        'status',
    ];

    protected $casts = [
        'horas_totais' => 'decimal:3',
        'ano' => 'integer',
    ];

    public const STATUS_LIVRE = 'livre';
    public const STATUS_EM_SERVICO = 'em_servico';
    public const STATUS_MANUTENCAO = 'manutencao';
    public const STATUS_INATIVO = 'inativo';

    public function usos(): HasMany
    {
        return $this->hasMany(UsoMaquina::class);
    }

    public function manutencoes(): HasMany
    {
        return $this->hasMany(Manutencao::class);
    }
}
