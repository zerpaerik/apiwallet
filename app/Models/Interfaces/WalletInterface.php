<?php

namespace App\Models\Interfaces;

use App\Http\Requests\WalletRequest;

interface WalletInterface
{
    public function pay(WalletRequest $request);

    public function mapperData(array $data);

    public static function validateData();
}