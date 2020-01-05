<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchRequest extends FormRequest
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
            "team_lineup" => "required",
            "team_id" => "required|numeric",
            "match_date" => "required|date_format:Y-m-d",
            "match_hour" => "required|date_format:H:i",
            "opposing_team_id" => "required|numeric",
        ];
    }

    public function attributes()
    {
        return [
            "team_lineup" => "Escação do time da casa",
            "match_date" => "Data da Partida",
            "match_hour" => "Hora da Partida",
            "team_id" => "Time de Casa",
            "opposing_team_id" => "Time de Fora",
        ];
    }

    public function messages()
    {
        return [
            'team_lineup.required' => 'Informe a escalação do time de casa',
            'match_date.required' => 'Não pode realizar cadastro sem uma data para a partida',
            'match_hour.required' => 'Não pode realizar cadastro sem uma hora para a partida',
            'team_id.required' => 'Não pode realizar cadastro sem time, volte a tela anterior e selecione um time.',
            'opposing_team_id.required' => 'Não pode realizar cadastro sem time, volte a tela anterior e selecione um time.',
        ];
    }
}
