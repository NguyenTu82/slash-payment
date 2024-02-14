<?php

namespace App\Services\SlashWeb3Api;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

trait SlashWeb3ApiClient
{
    
    private $httpClient;

    private $bearerToken;

    /**
     * Initalize Http Client
     *
     * @return Client
     */
    protected function initHttpClient(): Client
    {
        /** @phpstan-ignore-next-line */
        if (!$this->httpClient) {
            $this->httpClient = new Client([
                "base_uri" => config('slashweb3payment.url') ?? 'https://testnet.slash.fi',
                "headers" => [
                    "Content-Type" => "application/json",
                ],
            ]);
        }

        return $this->httpClient;
    }

    protected function getAuth()
    {
        return empty($this->bearerToken)
            ? []
            : [
                "headers" => [
                    "Authorization" => "Bearer $this->bearerToken",
                ],
            ];
    }
    /**
     * Send HTTP Post Request
     *
     * @param  string $url
     * @param  array $body
     */
    public function post(string $url, array $body)
    {
        try {
            return $this->initHttpClient()->post(
                $url,
                array_merge(
                    [
                        "json" => $body,
                    ],
                    $this->getAuth()
                )
            );
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Send HTTP Get Request
     *
     * @param  string $url
     */
    public function get(string $url, $param)
    {
        try {
            return $this->initHttpClient()->get($url,array_merge(["query" =>$param] ,$this->getAuth()));
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Send HTTP Get Request
     *
     * @param  string $url
     */
    public function delete(string $url)
    {
        try {
            return $this->initHttpClient()->delete($url, $this->getAuth());
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Send HTTP Patch Request
     *
     * @param  string $url
     * @param  array $body
     */
    public function patch(string $url, array $body)
    {
        return $this->initHttpClient()->patch(
            $url,
            array_merge(
                [
                    "json" => $body,
                ],
                $this->getAuth()
            )
        );
    }

    /**
     * Send HTTP Request
     *
     * @param  string $url
     * @param  array $body
     * @param  string $httpMethod
     * @throws Exception
     */
    public function request(
        string $url,
        array $body = [],
        string $httpMethod = "POST"
    ) {
        if ($httpMethod == "POST") {
            return $this->post($url, $body);
        }

        if ($httpMethod == "GET") {
            return $this->get($url,$body);
        }

        if ($httpMethod == "DELETE") {
            return $this->delete($url);
        }

        if ($httpMethod == "PATCH") {
            return $this->patch($url, $body);
        }

        throw new Exception("HTTP Not supported for this endpoint");
    }

    public function setBearer($bearer)
    {
        $this->bearerToken = $bearer;
    }
}
