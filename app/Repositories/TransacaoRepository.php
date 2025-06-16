<?php

namespace App\Repositories;

use App\Models\Transacao;

class TransacaoRepository
{
    public function criar(array $data): Transacao
    {
        return Transacao::create($data);
    }

    public function buscarPorId(string $id): ?Transacao
    {
        return Transacao::find($id);
    }

    public function atualizar(Transacao $transacao, array $data): Transacao
    {
        $transacao->update($data);
        return $transacao;
    }

    public function buscarPorCarteiraId(int $carteiraId)
    {
        return Transacao::where('carteira_id', $carteiraId) // deposito
            ->orWhere('carteira_origem_id', $carteiraId)    // enviada
            ->orWhere('carteira_destino_id', $carteiraId)   // recebida
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function buscarPorIdComRelacionamentos(int $id): ?Transacao
    {
        return Transacao::with([
            'carteira.usuario',
            'carteiraOrigem.usuario',
            'carteiraDestino.usuario',
            'transacaoRevertida'
        ])->find($id);
    }
}
