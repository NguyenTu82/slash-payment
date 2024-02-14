<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ExampleRepository.
 *
 * @package namespace App\Repositories\AdminEpay;
 */
interface ExampleRepository extends RepositoryInterface
{
    public function getExamples($filter);
}
