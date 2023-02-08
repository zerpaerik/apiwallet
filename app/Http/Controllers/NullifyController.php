<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use Illuminate\Http\Request;
use App\Models\Wallets\EndenredModel;

class NullifyController extends Controller
{

    public function execute(Request $request)
    {

        $rules = [
            'wallet'      => 'required|string',
            'applicationUid'      => 'required|string',
            'commerceUid'      => 'required|string',
            'commerceBuyOrder'      => 'required|string',
            'branchIdentifier'     => 'required|string',
        ];

        // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [
                'created' => false,
                'errors'  => $validator->errors()->all()
            ];
        }

        $WalletRequest = WalletRequest::createFrom($request);

        $className = "\\App\Models\\Wallets\\" . ucfirst(strtolower($request->wallet)) . "Model";
        $Wallet = new $className;

        $result = $Wallet->nullify($WalletRequest);

        return [
            'response' => $result,
            'status' => 1
        ];

    }

    //
}
