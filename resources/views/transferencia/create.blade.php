@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Faça uma Transferência</h3>
        </div>
        <div class="card-body">
            <form id="form-transferencia" action="{{ route('transferencia.store') }}" method="POST" novalidate>
                @csrf
                <div class="mb-3 d-flex gap-2 align-items-center">
                    <div class="flex-grow-1">
                        <label for="chave" class="form-label fw-semibold">Chave da carteira de destino</label>
                        <input type="text" id="chave" class="form-control form-control-lg" placeholder="Ex: ca3248d6-208c-4978-a642-8ba0387" required>
                        <div id="feedback-chave" class="form-text mt-1" style="display:none;"></div>
                    </div>
                    <button type="button" id="btn-verificar" class="btn btn-outline-primary mt-4" style="height: 42px;">
                        Verificar
                    </button>
                </div>

                <!-- Campo hidden para guardar o carteira_destino_id -->
                <input type="hidden" name="carteira_destino_id" id="carteira_destino_id" value="{{ old('carteira_destino_id') }}">
                @error('carteira_destino_id')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror

                <div class="mb-4">
                    <label for="valor" class="form-label fw-semibold">Valor da transferência</label>
                    <input
                        type="number"
                        step="0.01"
                        name="valor"
                        id="valor"
                        class="form-control form-control-lg @error('valor') is-invalid @enderror"
                        placeholder="0.00"
                        required
                        value="{{ old('valor') }}">
                    @error('valor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" id="btn-submit" class="btn btn-primary btn-lg rounded-pill" disabled>
                        Confirmar Transferência
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const btnVerificar = document.getElementById('btn-verificar');
    const inputChave = document.getElementById('chave');
    const feedbackChave = document.getElementById('feedback-chave');
    const btnSubmit = document.getElementById('btn-submit');
    const carteiraDestinoIdInput = document.getElementById('carteira_destino_id');

    btnVerificar.addEventListener('click', () => {
        const chave = inputChave.value.trim();

        if (!chave) {
            feedbackChave.textContent = 'Por favor, insira uma chave para verificar.';
            feedbackChave.style.color = 'red';
            feedbackChave.style.display = 'block';
            btnSubmit.disabled = true;
            carteiraDestinoIdInput.value = '';
            return;
        }

        fetch(`/api/carteira/verificar-chave/${chave}`)
            .then(response => {
                if (response.ok) return response.json();
                throw new Error('Chave inválida');
            })
            .then(data => {
                feedbackChave.textContent = 'Chave válida! Você pode prosseguir com a transferência.';
                feedbackChave.style.color = 'green';
                feedbackChave.style.display = 'block';
                btnSubmit.disabled = false;
                carteiraDestinoIdInput.value = data.carteira_destino_id;
            })
            .catch(err => {
                feedbackChave.textContent = 'Chave inválida. Por favor, verifique.';
                feedbackChave.style.color = 'red';
                feedbackChave.style.display = 'block';
                btnSubmit.disabled = true;
                carteiraDestinoIdInput.value = '';
            });
    });
</script>
@endsection