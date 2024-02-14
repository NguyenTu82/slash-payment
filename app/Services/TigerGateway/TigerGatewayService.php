<?php

namespace App\Services\TigerGateway;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use App\Services\TigerGateway\Response;
use Exception;
use Closure;

class TigerGatewayService
{
    use TigerGatewayClient;

    const API_WITHDRAWAL = "/api/v1/withdrawal";
    const GET_WITHDRAWAL_LIST = "/api/v1/withdrawal/list";

    public function __construct()
    {
    }

    public function postWithdrawal(array $data)
    {
        $this->setBearer(config('twg.token'));
        return new Response($this->request(self::API_WITHDRAWAL, array_merge($data)));
    }



    public function getListWithdrawal($param = [])
    {
        $this->setBearer(config('twg.token'));
        return new Response(
            $this->request(self::GET_WITHDRAWAL_LIST,$param, httpMethod: "GET")
        );
    }

}
