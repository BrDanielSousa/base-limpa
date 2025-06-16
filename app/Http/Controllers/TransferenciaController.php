<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransferenciaRequest;
use App\Services\CarteiraService;
use App\Services\TransacaoService;
use Illuminate\Support\Facades\Auth;

class TransferenciaController extends Controller
{
    protected $carteiraService;
    protected $transacaoService;

    public function __construct(CarteiraService $carteiraService, TransacaoService $transacaoService)
    {
        $this->carteiraService = $carteiraService;
        $this->transacaoService = $transacaoService;
    }

    public function create()
    {
        return view('transferencia.create');
    }

    public function store(StoreTransferenciaRequest $request)
    {
        $dados = $request->validated();
        $usuario = Auth::user();

        try {
            
            $this->carteiraService->transferir(
                $usuario,
                $dados
            );

            return redirect()->route('dashboard')->with('success', 'Transferência realizada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
