<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TransacaoService;

class HistoricoTransacaoController extends Controller
{
     protected $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function historico(int $transacaoId)
    {
        $transacao = $this->transacaoService->historico($transacaoId);

        return view('transacoes.historico', compact('transacao'));
    }
}
