<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TransacaoService;
use Illuminate\Http\Request;

class ReversaoTransacaoController extends Controller
{
    protected $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function reverter(int $transacaoId)
    {

        try {
            $this->transacaoService->reverter($transacaoId);

            return back()->with('success', 'Transação revertida com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
