<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "number" => "required|numeric",
            "position" => "required",
            "team_id" => "required|numeric",
        ];
    }

    public function attributes()
    {
        return [
            "name" => "Nomde do Jogador",
            "number" => "Numero do jogador",
            "position" => "Posição do jogador",
            "team_id" => "Time",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Informe o nome do jogador',
            'number.required' => 'Informe o numero do jogador',
            'position.required' => 'Não pode realizar cadastro sem uma posição',
            'team_id.required' => 'Não pode realizar cadastro sem time, volte a tela anterior e selecione um time.',
        ];
    }
}
