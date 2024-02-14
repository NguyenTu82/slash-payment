<?php

namespace App\Services\TigerGateway;

use GuzzleHttp\Psr7\Response as Psr7Response;

class Response
{
    protected int $httpStatusCode;

    protected bool $hasError = false;

    /**
     * Response data
     *
     * @var string
     */
    protected $responseData;

    /**
     * Error message bag
     *
     * @var array
     */
    protected $errorMessages = [];

    protected $reason;

    /**
     * Append data
     *
     * @var array
     */
    private $appendData = [];

    /**
     * Initialize Response data
     *
     * @param  mixed $result
     * @param  array $appendData
     * @return void
     */
    public function __construct($result, array $appendData = [])
    {
        $this->createResponseData($result);
        $this->appendData = $appendData;
    }

    public static function parse($response)
    {
        return new self($response);
    }

    public function hasError(): bool
    {
        return $this->hasError;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function getErrorReason(): string
    {
        return $this->reason;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getResult(): array
    {
        $result = json_decode($this->responseData, true);
        if (!$result) {
            parse_str($this->responseData, $result);
        }
        return array_merge($result, $this->appendData);
    }

    protected function createResponseData(Psr7Response $response): void
    {
        $this->httpStatusCode = $response->getStatusCode();
        if (!$this->checkApiHasErrorCode((string) $response->getBody())) {
            $this->responseData = (string) $response->getBody();
        }
    }

    protected function checkApiHasErrorCode(string $response): bool
    {
        $check = str_contains(strtolower($response), "success");
        
        if ($check == false) {
            $this->hasError = true;
            $res = json_decode($response, true);
            $this->errorMessages = $res["data"] ?? [];
            $this->reason = $res["message"];
            return true;
        }

        return false;
    }

    public function getResponseData()
    {
        return $this->responseData;
    }
}
