<?php
 
namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use Illuminate\Http\Request;
use App\Models\Wallets\EndenredModel;

 
 
class PaymentController extends Controller
{

    
    public function execute(Request $request)
    {


        if($request->wallet == 'Endenred'){

        $rules = [
            'wallet'      => 'required|string',
            'applicationUid'      => 'required|string',
            'commerceUid'      => 'required|string',
            'otp'      => 'required|string',
            'cardNumber'      => 'required|string',
            'commerceBuyOrder'      => 'required|string',
            'amount'      => 'required|string',
            'currency'     => 'required|string',
            'type'     => 'required|string',
            'branchIdentifier'     => 'required|string',
            'posIdentifier'     => 'required|string',
            'sequenceNumber'     => 'required|int'
        ];

        } else {

          /*  $rules = [
                'fiscalId'      => 'required|string',
                'pan'      => 'required|string',
                'dpass'      => 'required|string',
                'clientFiscalId'      => 'required|string',
                'amount'      => 'required|string',
                'serviceId'      => 'required|string',
                'code'      => 'required|string',
                'branchCode'     => 'required|string',
                'terminal'     => 'required|string'
            ];*/
            
        }

       /* $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [
                'created' => false,
                'errors'  => $validator->errors()->all()
            ];
        }*/

        $WalletRequest = WalletRequest::createFrom($request);

        $className = "\\App\Models\\Wallets\\" . ucfirst(strtolower($request->wallet)) . "Model";
        $Wallet = new $className;

        $result = $Wallet->pay($WalletRequest);

        return [
            $result
        ];

    }

   


    


}