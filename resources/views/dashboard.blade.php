@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="mb-4">Bem-vindo à sua carteira digital</h1>

    {{-- SALDO E CHAVE --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-header bg-success text-white">
                    Saldo Atual
                </div>
                <div class="card-body">
                    <h3 class="card-title text-success">{{ $carteira->saldo_formatado }}</h3>
                    <p class="text-muted mb-0">Disponível na sua carteira</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-info shadow-sm">
                <div class="card-header bg-info text-white">
                    Chave da Carteira
                </div>
                <div class="card-body">
                    <h5 class="card-text text-info">{{ $carteira->chave }}</h5>
                    <p class="text-muted mb-0">Use essa chave para receber transferências</p>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-12">
            <h4 class="mb-3">Histórico de Transações</h4>
            <ul class="list-group shadow-sm">
                @forelse ($transacoes as $transacao)
                <li class="list-group-item d-flex justify-content-between align-items-center">

                    <div>
                        @if ($transacao->tipo === 'deposito')
                        <strong>Depósito</strong>
                        <span class="badge bg-info ms-2">+ R$ {{ number_format($transacao->valor, 2, ',', '.') }}</span>

                        @elseif ($transacao->tipo === 'transferencia' && $transacao->carteira_origem_id == $carteira->id)
                        <strong>Transferência Enviada</strong>
                        <span class="badge bg-danger ms-2">- R$ {{ number_format($transacao->valor, 2, ',', '.') }}</span>

                        @elseif ($transacao->tipo === 'transferencia' && $transacao->carteira_destino_id == $carteira->id)
                        <strong>Transferência Recebida</strong>
                        <span class="badge bg-success ms-2">+ R$ {{ number_format($transacao->valor, 2, ',', '.') }}</span>

                        @elseif ($transacao->tipo === 'reversao')
                        <strong>Reversão</strong>
                        <span class="badge bg-warning text-dark ms-2">
                            {{ $transacao->carteira_destino_id == $carteira->id ? '+' : '-' }}
                            R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                        </span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <!-- Botão de histórico -->
                        <a href="{{ route('transacoes.historico', $transacao->id) }}" class="btn btn-info btn-sm">Histórico</a>

                        @if ($transacao->tipo !== 'reversao' && !$transacao->reversao)
                        <form method="POST" action="{{ route('reverter', $transacao->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-sm">Reverter</button>
                        </form>
                        @elseif ($transacao->tipo === 'reversao')
                        <span class="badge bg-secondary">Reversão</span>
                        @else
                        <span class="badge bg-secondary">Revertida</span>
                        @endif
                    </div>

                </li>
                @empty
                <li class="list-group-item text-muted">Nenhuma transação encontrada.</li>
                @endforelse
            </ul>

        </div>
    </div>
</div>
@endsection