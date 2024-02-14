<?php

namespace App\Repositories;

use App\Models\Example;
use App\Validators\AdminEpay\ExampleValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ExampleRepositoryEloquent.
 *
 * @package namespace App\Repositories\AdminEpay;
 */
class ExampleRepositoryEloquent extends BaseRepository implements ExampleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Example::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return ExampleValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function getExamples($filter) {
        $data = $this->model
            ->when(isset($filter->name), function ($q) use ($filter) {
                $q->where('name', 'like', "%$filter->name%");
            })
            ->when(!empty($filter->start_at), function ($query) use ($filter) {
                $query->whereDate('created_at', '>=', $filter->start_at);
            })
            ->when(!empty($filter->end_at), function ($query) use ($filter) {
                $query->whereDate('created_at', '<=', $filter->end_at);
            });

        return $data;
    }
}
