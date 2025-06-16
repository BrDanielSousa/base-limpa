<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositoRequest;
use App\Services\CarteiraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositoController extends Controller
{
    protected $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }
    
    public function create()
    {

        return view('deposito.create');
    }

    public function store(StoreDepositoRequest $request)
    {
        $dados = $request->validated();
        $usuario = Auth::user();

        try {
            
            $this->carteiraService->depositar($usuario->carteira->id,  $dados['valor']);

            return redirect()->route('dashboard')->with('success', 'Depósito realizado com sucesso!');
        } catch (\Exception $e) {
           return back()->with('error', $e->getMessage());
        }
    }
}
