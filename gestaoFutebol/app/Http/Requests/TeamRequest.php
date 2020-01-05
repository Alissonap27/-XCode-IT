<?php

namespace SIEC\Http\Requests;

use SIEC\Http\Requests\Request;

class SubscriptionSaveRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "responsible_identification_document" => "required",
            "responsible_name" => "required",
            "student_name" => "required",
            "birth_date" => "required|date_format:Y-m-d",
            "student_identification_document" => "required",
            "mother_name" => "required",
            "cep" => "required",
            "city" => "required",
            "district" => "required",
            "street" => "required",
            "number" => "required|numeric",
            "study_with_brother" => "required",
            "brother_name" => "required_if:study_with_brother,1",
            "school_first" => "required",
            "school_second" => "required",
            "school_third" => "required",
            "school_grade" => "required",
            "transfer" => "required",
            "network_school" => "required_if:transfer,1",
            "accept_term" => "accepted",
        ];
    }

    public function attributes()
    {
        return [
            "responsible_identification_document" => "CPF do responsável",
            "responsible_name" => "Nome do responsável",
            "student_name" => "Nome do Aluno",
            "birth_date" => "Data de nascimento",
            "student_identification_document" => "N° da Certidão de nascimento",
            "mother_name" => "Nome completo da mãe",
            "cep" => "CEP",
            "city" => "Cidade",
            "district" => "Bairro",
            "street" => "Logradouro",
            "number" => "Número",
            "study_with_brother" => "Há interesse de de que o aluno estude na mesma escola do irmã ou da irmã ?",
            "brother_name" => "Se sim, informar o nome completo do irmão ou irmã",
            "school_first" => "Escola pretendida (1° opção)",
            "school_second" => "Escola pretendida (2° opção)",
            "school_third" => "Escola pretendida (3° opção)",
            "school_grade" => "Série/Ano",
            "transfer" => "É aluno da rede municipal solicitando tranferência de escola",
            "network_school" => "Se sim, indique a escola de origem (onde o aluno estuda atualmente)",
            "accept_term" => "Li e aceito os termos e condições",
        ];
    }

    public function messages()
    {
        return [
           "brother_name.required_if" => "O campo nome completo do irmão ou irmã é obrigatório.",
           "network_school.required_if" => "O campo escola de origem (onde o aluno estuda atualmente) é obrigatório.",
        ];
    }
}
