<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ExchangeRateRepository;
use App\Models\ExchangeRate;

/**
 * Class ExchangeRateRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExchangeRateRepositoryEloquent extends BaseRepository implements ExchangeRateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExchangeRate::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
