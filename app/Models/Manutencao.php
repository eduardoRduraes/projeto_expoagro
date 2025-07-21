<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manutencao extends Model
{
    use HasFactory;

    protected $table = 'manutencoes';
    protected $fillable = [
        'tipo',
        'custo',
        'descricao',
        'maquina_id'
    ];

    protected $casts = [
        'custo' => 'decimal:3',
    ];

    public const TIPO_PREVENTIVA = 'preventiva';
    public const TIPO_CORRETIVA = 'corretiva';

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class);
    }
}
