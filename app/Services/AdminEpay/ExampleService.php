<?php

namespace App\Services\AdminEpay;

use App\Models\Example;
use App\Repositories\ExampleRepository;


class ExampleService
{
    protected ExampleRepository $exampleRepository;

    /**
     *  constructor
     *
     * @param ExampleRepository $exampleRepository
     */
    public function __construct(
        ExampleRepository $exampleRepository
    ){
        $this->exampleRepository = $exampleRepository;
    }

    /**
     * @return null|Example
     */
    public function getList(object $filter)
    {
        return $this->exampleRepository->getExamples($filter);
    }

}
