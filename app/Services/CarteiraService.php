<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\CarteiraRepository;
use Exception;
use Illuminate\Support\Str;

class CarteiraService
{
    protected $carteiraRepository;
    protected $transacaoService;

    public function __construct(CarteiraRepository $carteiraRepository, TransacaoService $transacaoService)
    {
        $this->carteiraRepository = $carteiraRepository;
        $this->transacaoService = $transacaoService;
    }

    public function buscarCarteiraPorUsuarioId(int $usuarioId)
    {
        return $this->carteiraRepository->buscarPorUsuarioId($usuarioId);
    }

    public function buscarPorChave(string $chave)
    {
        return $this->carteiraRepository->buscarPorChave($chave);
    }

    public function buscarCarteiraPorId(string $id)
    {
        return $this->carteiraRepository->buscarPorId($id);
    }

    public function criarCarteira(User $user)
    {
        $dados = [
            'usuario_id' => $user->id,
            'chave' => Str::uuid(),
            'saldo' => 0,
        ];

        return $this->carteiraRepository->criar($dados);
    }

    public function depositar(int $carteiraId, float $valor): void
    {
        $carteira = $this->carteiraRepository->buscarPorId($carteiraId);

        if (!$carteira) {
            throw new \Exception("Carteira não encontrada.");
        }

        $carteira->depositar($valor);

        $this->transacaoService->criarTransacao([
            'carteira_id' => $carteira->id,
            'tipo' => 'deposito',
            'valor' => $valor,
        ]);
    }

    public function transferir(User $usuario, array $dados): void
    {
        $carteiraOrigem = $usuario->carteira;
        $carteiraDestinoId = $dados['carteira_destino_id'];

        if ($carteiraOrigem->id == $carteiraDestinoId) {
            throw new \Exception("Não é permitido transferir para a própria carteira.");
        }

        $carteiraOrigem = $this->buscarCarteiraPorId($carteiraOrigem->id);
        $carteiraDestino = $this->buscarCarteiraPorId($carteiraDestinoId);

        if (!$carteiraOrigem || !$carteiraDestino) {
            throw new \Exception("Carteira de origem ou destino não encontrada.");
        }

        if (!$carteiraOrigem->verificarSaldo($dados['valor'])) {
            throw new \Exception("Saldo insuficiente.");
        }

        $carteiraOrigem->sacar($dados['valor']);
        $carteiraDestino->depositar($dados['valor']);

        $carteiraOrigem->save();
        $carteiraDestino->save();

        $this->transacaoService->criarTransacao([
            'carteira_id' => $carteiraOrigem->id,
            'carteira_origem_id' => $carteiraOrigem->id,
            'carteira_destino_id' => $carteiraDestinoId,
            'tipo' => 'transferencia',
            'valor' => $dados['valor'],
        ]);
    }
}
