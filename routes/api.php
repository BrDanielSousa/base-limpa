<?php

use App\Http\Controllers\API\CarteiraApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/carteira/verificar-chave/{chave}', [CarteiraApiController::class, 'verificarChave']);
