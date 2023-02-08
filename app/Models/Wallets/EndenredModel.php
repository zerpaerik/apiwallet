<?php

namespace App\Models\Wallets;

use App\Http\Requests\WalletRequest;
use App\Models\Interfaces\WalletInterface;
use Illuminate\Support\Facades\Log;
use PDOException;

class EndenredModel implements WalletInterface
{
    public function pay(WalletRequest $request)
    {
        try{
            $data = json_decode($request->getContent(), true);

            $dataMapper = $this->mapperData($data);
       
            $header_array = array(
                'Content-Type: application/json; charset=UTF-8',
                'Accept: application/json',
            );

           // return $dataMapper;

           // $url = "https://lbqa.ionix.cl/edenred-retail-proxy/payment/authorizeByUser";

            $url = "https://mocki.io/v1/025a5000-bf5d-40aa-a3be-5e68e416635c";
            
            $ch = curl_init($url);
           // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
           // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataMapper);
            $result = curl_exec($ch);
            $result = json_decode($result,true);
            
            curl_close($ch);

        }catch(PDOException $ex){
            Log::error($ex->getMessage());
            $mensajeError = $ex->getMessage();
            return false;
        }

        return $result; 
    }


    public function revert(WalletRequest $request)
    {
        try{
            $data = json_decode($request->getContent(), true);

            $dataMapper = $this->mapperDataR($data);
       
            $header_array = array(
                'Content-Type: application/json; charset=UTF-8',
                'Accept: application/json',
            );

            
           // $url = "https://lbqa.ionix.cl/edenred-retail-proxy/payment/reverse";

            $url = "https://mocki.io/v1/998e594e-6bf4-4363-a4c8-b98e7fa2f0dd";
            
            $ch = curl_init($url);
           // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
           // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataMapper);
            $result = curl_exec($ch);
            $result = json_decode($result,true);
            
            curl_close($ch);

        }catch(PDOException $ex){
            Log::error($ex->getMessage());
            $mensajeError = $ex->getMessage();
            return false;
        }

        return $result; 
    }

    public function nullify(WalletRequest $request)
    {
        try{
            $data = json_decode($request->getContent(), true);

            $dataMapper = $this->mapperDataR($data);
       
            $header_array = array(
                'Content-Type: application/json; charset=UTF-8',
                'Accept: application/json',
            );
            
           // $url = "https://lbqa.ionix.cl/edenred-retail-proxy/payment/nullifyTransaction";

            $url = "https://mocki.io/v1/998e594e-6bf4-4363-a4c8-b98e7fa2f0dd";
            
            $ch = curl_init($url);
           // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
           // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataMapper);
            $result = curl_exec($ch);
            $result = json_decode($result,true);
            
            curl_close($ch);

        }catch(PDOException $ex){
            Log::error($ex->getMessage());
            $mensajeError = $ex->getMessage();
            return false;
        }

        return $result; 
    }

    public function mapperData(array $data)
    {

        $configurationData = array(
            "applicationUid"  => $data['applicationUid'],
            "commerceUid"  => $data['commerceUid']
        );

        $authorizationData = array(
            "otp"  => $data['otp'],
            "cardNumber"  => $data['cardNumber']
        );

        $transactionData = array(
            "commerceBuyOrder"  => $data['commerceBuyOrder'],
            "currency"  => $data['currency'],
            "amount"  => $data['amount'],
            "type"  => $data['type'],
            "branchIdentifier"  => $data['branchIdentifier'],
            "posIdentifier"  => $data['posIdentifier'],
            "sequenceNumber"  => $data['sequenceNumber'],
        );


        return array(
            "configurationData"  => $configurationData,
            "authorizationData"  => $authorizationData,
            "transactionData"  => $transactionData
        );
        

    }

    public function mapperDataR(array $data)
    {

        $configurationData = array(
            "applicationUid"  => $data['applicationUid'],
            "commerceUid"  => $data['commerceUid']
        );
        $transactionData = array(
            "commerceBuyOrder"  => $data['commerceBuyOrder'],
            "branchIdentifier"  => $data['branchIdentifier']
        );


        return array(
            "configurationData"  => $configurationData,
            "transactionData"  => $transactionData
        );
  
    }


    public function getToken()
    {
        try{
           
       
            $header_array = array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic UjJkcHhRM3ZQcnRmZ0Y3MjpmRHc3TXBrazVjekhOdVNSdG1oR21BR0w0MkNheFFCOQ',
            );
            
            $url = "https://testing.sodexo.cl/auth/get-token";
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
           // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataMapper);
            $result = curl_exec($ch);
            $result = json_decode($result,true);
            
            curl_close($ch);

        }catch(PDOException $ex){
            Log::error($ex->getMessage());
            $mensajeError = $ex->getMessage();
            return false;
        }

        return $result; 
    }

    public static function validateData()
    {
        return [
            "wallet" => "bail|required",
            "amount" => "bail|required|string",
            "currency" => "bail|required|string",
            "type" => "bail|required|string",
            "commercePaymentCode" => "bail|required|string",
        ];
        
    }
}
