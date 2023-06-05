<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * App\Models\Evento
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $titulo
 * @property string|null $descricao
 * @property \Illuminate\Support\Carbon|null $previsao_inicio
 * @property \Illuminate\Support\Carbon|null $previsao_fim
 * @property \Illuminate\Support\Carbon|null $data_inicio
 * @property \Illuminate\Support\Carbon|null $data_fim
 * @property mixed|null $nota_interna
 * @property int|null $status_enum
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membro> $membros
 * @property-read int|null $membros_count
 * @method static \Database\Factories\EventoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Evento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Evento query()
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereDataFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereDataInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereNotaInterna($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento wherePrevisaoFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento wherePrevisaoInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereStatusEnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
