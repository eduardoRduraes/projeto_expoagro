<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        'data' => 'date',
        'hora_inicio' => 'datetime:H:i',
        'hora_fim' => 'datetime:H:i',
        'total_horas' => 'decimal:3',
    ];


    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class);
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class);
    }
}
