<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CarteiraService;
use Illuminate\Http\JsonResponse;

class CarteiraApiController extends Controller
{
    protected $carteiraService;

    public function __construct(CarteiraService $carteiraService)
    {
        $this->carteiraService = $carteiraService;
    }

    public function verificarChave(string $chave): JsonResponse
    {
        $carteira = $this->carteiraService->buscarPorChave($chave);

        if (!$carteira) {
            return response()->json(['message' => 'Chave não encontrada'], 404);
        }

        return response()->json([
            'success' => true,
            'carteira_destino_id' => $carteira->id,
        ], 200);
    }
}
