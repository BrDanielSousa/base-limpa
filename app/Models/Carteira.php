<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Carteira extends Model
{
    protected $table = 'carteiras';

    protected $fillable = [
        'usuario_id',
        'chave',
        'saldo',
    ];

    protected $casts = [
        'saldo' => 'float',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function verificarSaldo(float $valor): bool
    {
        return $this->saldo >= $valor;
    }

    public function depositar(float $valor): void
    {
        $this->saldo += $valor;
        $this->save();
    }

    public function sacar(float $valor, bool $ignorarVerificacao = false): void
    {
        if (!$ignorarVerificacao && !$this->verificarSaldo($valor)) {
            throw new \Exception('Saldo insuficiente');
        }

        $this->saldo -= $valor;
        $this->save();
    }

    protected function saldoFormatado(): Attribute
    {
        return Attribute::make(
            get: fn() => 'R$ ' . number_format($this->saldo, 2, ',', '.')
        );
    }
}
