<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\MembroEvento
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $evento_id
 * @property int $membro_id
 * @property mixed|null $nota_interna
 * @property bool|null $presente
 * @property-read \App\Models\Membro $evento
 * @property-read \App\Models\Membro $membro
 * @method static \Database\Factories\MembroEventoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento query()
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento whereMembroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento whereNotaInterna($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento wherePresente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembroEvento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MembroEvento extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'membro_id',
        'nota_interna',
        'presente',
    ];

    protected $casts = [
        'presente' => 'boolean',
        'nota_interna' => 'hashed',
    ];

    protected $hidden = [
        'nota_interna',
    ];

    /**
     * Get the membro that owns the MembroEvento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function membro(): BelongsTo
    {
        return $this->belongsTo(Membro::class, 'membro_id', 'id');
    }

    /**
     * Get the evento that owns the MembroEvento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Membro::class, 'evento_id', 'id');
    }
}
