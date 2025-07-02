<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manutencao extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'tipo',
        'horas_maquina',
        'custo',
        'descricao',
        'maquina_id'

    ];

    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }
}
