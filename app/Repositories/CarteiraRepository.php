<?php

namespace App\Repositories;

use App\Models\Carteira;

class CarteiraRepository
{
    public function buscarPorUsuarioId(int $userId)
    {
        return Carteira::where('usuario_id', $userId)->first();
    }

    public function buscarPorChave(string $chave): ?Carteira
    {
        return Carteira::where('chave', $chave)->first();
    }

    public function buscarPorId(string $id)
    {
        return Carteira::find($id);
    }

    public function criar(array $data)
    {
        return Carteira::create($data);
    }

    public function atualizar(Carteira $carteira, array $data)
    {
        $carteira->update($data);
        return $carteira;
    }
}
