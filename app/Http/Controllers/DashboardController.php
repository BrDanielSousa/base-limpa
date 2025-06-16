<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CarteiraService;
use App\Services\TransacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $carteiraService;
    protected $transacaoService;

    public function __construct(CarteiraService $carteiraService, TransacaoService $transacaoService)
    {
        $this->carteiraService = $carteiraService;
        $this->transacaoService = $transacaoService;
    }

    public function index()
    {
        $user = Auth::user();

        $carteira = $this->carteiraService->buscarCarteiraPorUsuarioId($user->id);
        $transacoes = $this->transacaoService->buscarTransacoesDaCarteira($carteira->id);

        return view('dashboard', compact('carteira', 'transacoes'));
    }
}
