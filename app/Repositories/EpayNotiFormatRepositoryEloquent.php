<?php

namespace App\Repositories;

use App\Enums\NotiFromType;
use App\Models\EpayReceiveNotiForm;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class EpayNotiRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EpayNotiFormatRepositoryEloquent extends BaseRepository implements EpayNotiFormatRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EpayReceiveNotiForm::class;
    }

    /**
     * @param $request
     * @return mixed
     */

    public function getAllNotiTemplate()
    {
        return $this->model->where('from_type', NotiFromType::FROM_USER)->get();
    }
}
