<?php

namespace App\Services\Bank;

use App\Services\Bank\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Exception;
use Closure;

class BankService
{
    use BankClient;

    const GET_BANK = "/banks";

    public function __construct()
    {
    }

    public function getBank($id)
    {
        return new Response(
            $this->request(self::GET_BANK."/".$id.".json", httpMethod: "GET")
        );
    }

    public function getBranchBank($bank_code, $branch_code)
    {
        return new Response(
            $this->request(self::GET_BANK."/".$bank_code."/branches/".$branch_code.".json", httpMethod: "GET")
        );
    }

}
