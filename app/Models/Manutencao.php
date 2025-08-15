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
        'descricao',
        'tipo',
        'status',
        'custo',
        'data_manutencao',
        'responsavel',
        'maquina_id'
    ];

    protected $casts = [
        'custo' => 'decimal:3',
        'data_manutencao' => 'date',
    ];

    public const STATUS_LIVRE = 'livre';
    public const STATUS_MANUTENCAO = 'manutencao';
    public const TIPO_PREVENTIVA = 'preventiva';
    public const TIPO_CORRETIVA = 'corretiva';

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class);
    }
}
