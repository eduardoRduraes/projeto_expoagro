<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function usos()
    {
        return $this->hasMany(UsoMaquina::class);
    }

    public function manutencoes()
    {
        return $this->hasMany(Manutencao::class);
    }
}
