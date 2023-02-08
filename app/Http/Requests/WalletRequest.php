<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Response;

class WalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $mean = $this->toArray()['wallet'];
        $className = "\\App\Models\\Wallets\\" . ucfirst(strtolower($mean)) . "Model";
        
        return $className::validateData();
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, $this->buildResponse($validator)));
    }

    protected function buildResponse(Validator $validator)
    {
        $resp = Response::json(
            [
                'codigo' => 400,
                'mensaje' => "Error en validacion de datos recibidos",
                'causa' => $validator->errors()->first(),
                'consulta' => "",
            ]
        );

        return $resp;
    }




}
