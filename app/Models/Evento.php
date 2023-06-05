<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Evento extends Model
{
    use HasFactory;

    public const STATUS_A_REALIZAR = 0;
    public const STATUS_REALIZADO = 1;
    public const STATUS_NAO_REALIZADO = 2;
    public const STATUS_CANCELADO = 3;
    public const STATUS_DESCONHECIDO = 4;

    protected $fillable = [
        'titulo',
        'descricao',
        'nota_interna',
        'status_enum',
        'previsao_inicio',
        'previsao_fim',
        'data_inicio',
        'data_fim',
    ];

    protected $casts = [
        'previsao_inicio' => 'datetime',
        'previsao_fim' => 'datetime',
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'nota_interna' => 'hashed',
    ];

    protected $dates = [
        'data_inicio',
        'data_fim',
        'previsao_inicio',
        'previsao_fim',
    ];

    protected $hidden = [
        'nota_interna',
    ];

    /**
     * Get all of the membros for the Membro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function membros(): HasManyThrough
    {
        return $this->hasManyThrough(
            Membro::class,
            MembroEvento::class,
            'evento_id',
            'id',
            'id',
            'membro_id',
        );
    }
}
