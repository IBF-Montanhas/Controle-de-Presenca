<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * App\Models\Membro
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $nome
 * @property string|null $sobrenome
 * @property string|null $nome_amigavel
 * @property string|null $sexo
 * @property int|null $status_enum
 * @property int|null $tipo_enum
 * @property \Illuminate\Support\Carbon|null $data_de_nascimento
 * @property \Illuminate\Support\Carbon|null $membro_desde
 * @property \Illuminate\Support\Carbon|null $primeiro_registro
 * @property string|null $nota_publica
 * @property mixed|null $nota_interna
 * @property AsCollection|null $telefones
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Evento> $eventos
 * @property-read int|null $eventos_count
 * @method static \Database\Factories\MembroFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Membro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membro onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Membro query()
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereDataDeNascimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereMembroDesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereNomeAmigavel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereNotaInterna($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereNotaPublica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro wherePrimeiroRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereSobrenome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereStatusEnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereTelefones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereTipoEnum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membro withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Membro withoutTrashed()
 * @mixin \Eloquent
 */
class Membro extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_INATIVO = 0;
    public const STATUS_ATIVO = 1;

    public const TIPO_INDEFINIDO = 0;
    public const TIPO_MEMBRO = 1;
    public const TIPO_CRIANCA = 2;
    public const TIPO_ADOLESCENTE = 3;
    public const TIPO_VISITANTE = 4;

    protected $fillable = [
        'nome',
        'sobrenome',
        'nome_amigavel',
        'sexo',
        'status_enum',
        'tipo_enum',
        'data_de_nascimento',
        'membro_desde',
        'primeiro_registro',
        'nota_publica',
        'nota_interna',
        'telefones',
    ];

    protected $casts = [
        'data_de_nascimento' => 'datetime',
        'membro_desde' => 'datetime',
        'primeiro_registro' => 'datetime',
        'nota_interna' => 'hashed',
        'telefones' => AsCollection::class,
    ];

    protected $dates = [
        'data_de_nascimento',
        'membro_desde',
        'primeiro_registro',
    ];

    protected $hidden = [
        'nota_interna',
    ];

    /**
     * Get all of the eventos for the Membro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function eventos(): HasManyThrough
    {
        return $this->hasManyThrough(
            Evento::class,
            MembroEvento::class,
            'membro_id',
            'id',
            'id',
            'evento_id',
        );
    }
}
