<?php

namespace App\Models\Wallets;

use App\Http\Requests\WalletRequest;
use App\Models\Interfaces\WalletInterface;

class SodexoModel implements WalletInterface
{
    public function pay(WalletRequest $request)
    {


        try{

            $getToken = $this->getToken();
            $ex = isset($getToken->access_token) ? $getToken->access_token : "";
            $keyDynamic = $this->getDinamicKey($ex);
            $code = isset($keyDynamic->data->code) ? $keyDynamic->data->code : "";

            $data = json_decode($request->getContent(), true);
            $data['pass'] = $code;


            $dataMapper = $this->mapperData($data);

            $header_array = array(
                'Content-Type: application/json; charset=UTF-8',
                'Authorization: Bearer'.' '.$ex,
            );

            $url = "https://testing.sodexo.cl/api/delivery-key/sale";
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataMapper));
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

        $payment = array(
            "pan"  => $data['cardNumber'],
            "dpass"  => $data['pass'],
            "clientFiscalId"  => $data['commerceUid'],
            "amount"  => $data['amount']
        );

        $transaction = array(
            "serviceId"  => $data['serviceId']
        );

        $commerce = array(
            "code"  => $data['commerceBuyOrder'],
            "branchCode"  => $data['branchIdentifier'],
            "terminal"  => $data['posIdentifier']
        );

        return [
            'payment' => $payment,
            'transaction' => $transaction,
            'commerce' => $commerce
        ];
    }

    public static function validateData()
    {
        return "Sodexo - Valida la data que llega desde las cajas";    
    }

    public function getToken()
    {
        try{
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://testing.sodexo.cl/auth/get-token");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded","Authorization: Basic UjJkcHhRM3ZQcnRmZ0Y3MjpmRHc3TXBrazVjekhOdVNSdG1oR21BR0w0MkNheFFCOQ=="));
            $result = curl_exec($ch);
            $result = (object) json_decode($result);
            curl_close($ch);

        }catch(PDOException $ex){
            Log::error($ex->getMessage());
            $mensajeError = $ex->getMessage();
            return false;
        }

        return $result; 
    }

    public function getDinamicKey($token)
    {
        try{

            $client = array(
                "fiscalId"  => "60908000-0",
                "serviceId"  => 1
            );
    
            $card = array(
                "pan"  => 6060750000127666,
                "fiscalId"  => "10041998-K"
            );

            $fields = array(
                "client"  => $client,
                "card"  => $card
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://testing.sodexo.cl/api/delivery-key/getDinamicKey");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer"." ".$token));
            $result = curl_exec($ch);
            $result = (object) json_decode($result);
            curl_close($ch);

        }catch(PDOException $ex){
            Log::error($ex->getMessage());
            $mensajeError = $ex->getMessage();
            return false;
        }


        return $result; 
    }


}
