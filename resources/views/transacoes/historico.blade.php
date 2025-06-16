@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detalhes da Transação</h4>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Voltar</a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h5 class="text-secondary">Informações Gerais</h5>
                <p><strong>ID:</strong> {{ $transacao->id }}</p>
                <p><strong>Tipo:</strong> {{ ucfirst($transacao->tipo) }}</p>
                <p><strong>Valor:</strong> <span class="text-success">R$ {{ number_format($transacao->valor, 2, ',', '.') }}</span></p>
                <p><strong>Status:</strong>
                    @if($transacao->reversao)
                    <span class="badge bg-secondary">Revertida</span>
                    @else
                    <span class="badge bg-success">Ativa</span>
                    @endif
                </p>
                <p><strong>Data:</strong> {{ $transacao->created_at->format('d/m/Y H:i:s') }}</p>
                <p><strong>Última atualização:</strong> {{ $transacao->updated_at->format('d/m/Y H:i:s') }}</p>
            </div>

            <hr>

            @if($transacao->tipo === 'deposito')
            <h5 class="text-secondary">Carteira Envolvida</h5>
            <p><strong>ID da Carteira:</strong> {{ $transacao->carteira->id }}</p>
            <p><strong>Proprietário:</strong> {{ $transacao->carteira->usuario->name }}</p>
            <p><strong>E-mail:</strong> {{ $transacao->carteira->usuario->email }}</p>

            @elseif($transacao->tipo === 'transferencia')
            <h5 class="text-secondary">Carteira de Origem</h5>
            <p><strong>ID:</strong> {{ $transacao->carteiraOrigem->id }}</p>
            <p><strong>Proprietário:</strong> {{ $transacao->carteiraOrigem->usuario->name }}</p>
            <p><strong>E-mail:</strong> {{ $transacao->carteiraOrigem->usuario->email }}</p>

            <hr>

            <h5 class="text-secondary">Carteira de Destino</h5>
            <p><strong>ID:</strong> {{ $transacao->carteiraDestino->id }}</p>
            <p><strong>Proprietário:</strong> {{ $transacao->carteiraDestino->usuario->name }}</p>
            <p><strong>E-mail:</strong> {{ $transacao->carteiraDestino->usuario->email }}</p>

            @elseif($transacao->tipo === 'reversao')
            <h5 class="text-secondary">Transação Revertida</h5>
            <p><strong>ID Original:</strong> {{ $transacao->transacaoRevertida->id }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($transacao->transacaoRevertida->tipo) }}</p>
            <p><strong>Valor:</strong> R$ {{ number_format($transacao->transacaoRevertida->valor, 2, ',', '.') }}</p>

            <hr>

            @if($transacao->carteiraOrigem)
            <h5 class="text-secondary">Carteira Origem</h5>
            <p><strong>ID:</strong> {{ $transacao->carteiraOrigem->id }}</p>
            <p><strong>Proprietário:</strong> {{ $transacao->carteiraOrigem->usuario->name }}</p>
            <p><strong>E-mail:</strong> {{ $transacao->carteiraOrigem->usuario->email }}</p>
            @endif

            @if($transacao->carteiraDestino)
            <hr>
            <h5 class="text-secondary">Carteira Destino</h5>
            <p><strong>ID:</strong> {{ $transacao->carteiraDestino->id }}</p>
            <p><strong>Proprietário:</strong> {{ $transacao->carteiraDestino->usuario->name }}</p>
            <p><strong>E-mail:</strong> {{ $transacao->carteiraDestino->usuario->email }}</p>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection