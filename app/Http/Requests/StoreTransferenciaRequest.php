<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransferenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'valor' => 'required|numeric|min:0.01',
            'carteira_destino_id' => 'required|exists:carteiras,id',
        ];
    }

    /**
     * Mensagens personalizadas para erros de validação.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric'  => 'O valor deve ser um número.',
            'valor.min'      => 'O valor deve ser maior que zero.',
            'carteira_destino_id.required' => 'O campo carteira_destino_id é obrigatório.',
        ];
    }
}
