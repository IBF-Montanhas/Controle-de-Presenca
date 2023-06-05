<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
