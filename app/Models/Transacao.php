<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    protected $table = 'transacoes';

    protected $fillable = [
        'carteira_id',
        'carteira_origem_id',
        'carteira_destino_id',
        'tipo',
        'valor',
        'saldo_antes',
        'reversao',
        'transacao_revertida_id',
    ];

    protected $casts = [
        'valor' => 'float',
        'reverted' => 'boolean',
    ];

    public function carteira()
    {
        return $this->belongsTo(Carteira::class, 'carteira_id');
    }

    public function carteiraOrigem()
    {
        return $this->belongsTo(Carteira::class, 'carteira_origem_id');
    }

    public function carteiraDestino()
    {
        return $this->belongsTo(Carteira::class, 'carteira_destino_id');
    }

    public function transacaoRevertida()
    {
        return $this->belongsTo(self::class, 'transacao_revertida_id');
    }
}
