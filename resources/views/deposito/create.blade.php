@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Faça um Depósito</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('deposito.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="valor" class="form-label fw-semibold">Valor para depositar</label>
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
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    Depositar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection