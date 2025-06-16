<?php

namespace App\Services;

use App\Models\Transacao;
use App\Repositories\TransacaoRepository;


class TransacaoService
{
    public function __construct(private TransacaoRepository $transacaoRepository) {}

    public function criarTransacao(array $data): Transacao
    {
        return $this->transacaoRepository->criar($data);
    }

    public function buscarTransacaoPorId(string $id): ?Transacao
    {
        return $this->transacaoRepository->buscarPorId($id);
    }

    public function buscarTransacoesDaCarteira(int $carteiraId)
    {
        return $this->transacaoRepository->buscarPorCarteiraId($carteiraId);
    }

    public function reverter(int $transacaoId): void
    {
        $transacaoOriginal = $this->buscarTransacaoPorId($transacaoId);

        if (!$transacaoOriginal) {
            throw new \Exception('Transação não encontrada.');
        }

        if ($transacaoOriginal->reversao) {
            throw new \Exception('Esta transação já foi revertida.');
        }

        if (!in_array($transacaoOriginal->tipo, ['deposito', 'transferencia'])) {
            throw new \Exception('Apenas depósitos ou transferências podem ser revertidos.');
        }

        $carteiraOrigem = $transacaoOriginal->carteiraOrigem;
        $carteiraDestino = $transacaoOriginal->carteiraDestino;
        $valor = $transacaoOriginal->valor;

        if ($transacaoOriginal->tipo === 'deposito') {

            $transacaoOriginal->carteira->sacar($valor, true);
            $transacaoOriginal->carteira->save();
        }

        if ($transacaoOriginal->tipo === 'transferencia') {

            $carteiraDestino->sacar($valor, true);
            $carteiraOrigem->depositar($valor);

            $carteiraDestino->save();
            $carteiraOrigem->save();
        }

        $transacaoOriginal->reversao = true;
        $transacaoOriginal->save();

        // Registra nova transação do tipo reversão
        $this->criarTransacao([
            'carteira_id' => $transacaoOriginal->carteira_id,
            'carteira_origem_id' => $transacaoOriginal->carteira_destino_id,
            'carteira_destino_id' => $transacaoOriginal->carteira_origem_id,
            'tipo' => 'reversao',
            'valor' => $valor,
            'reversao' => false,
            'transacao_revertida_id' => $transacaoOriginal->id,
        ]);
    }

    public function historico(int $transacaoId): Transacao
    {
        $transacao = $this->transacaoRepository->buscarPorIdComRelacionamentos($transacaoId);

        if (!$transacao) {
            throw new \Exception("Transação não encontrada.");
        }

        return $transacao;
    }
}
