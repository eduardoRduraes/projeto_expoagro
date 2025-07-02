<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoMaquina extends Model
{
    use HasFactory;

    protected $table = 'usos_maquinas';
    protected $fillable = [
        'data',
        'hora_inicio',
        'hora_fim',
        'total_horas',
        'observacao',
        'tarefa',
        'maquina_id',
        'operador_id'
    ];


    public function maquina()
    {
        return $this->belongsTo(Maquina::class);
    }

    public function operador()
    {
        return $this->belongsTo(Operador::class);
    }
}
