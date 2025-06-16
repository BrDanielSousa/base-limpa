<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\HistoricoTransacaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReversaoTransacaoController;
use App\Http\Controllers\TransferenciaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Deposito
    Route::get('/deposito/create', [DepositoController::class, 'create'])->name('deposito.create');
    Route::post('/deposito', [DepositoController::class, 'store'])->name('deposito.store');

    //Transferencia
    Route::get('/transferencia/create', [TransferenciaController::class, 'create'])->name('transferencia.create');
    Route::post('/transferencia', [TransferenciaController::class, 'store'])->name('transferencia.store');

    //Reversao
    Route::post('/reverter/{transacao_id}', [ReversaoTransacaoController::class, 'reverter'])->name('reverter');

    //Historico
    Route::get('/transacoes/{transacao_id}/historico', [HistoricoTransacaoController::class, 'historico'])->name('transacoes.historico');


    //Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
