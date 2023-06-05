<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
