<?php

namespace App\Repositories;
use App\Models\Postal;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Enums\AdminAccountStatus;
/**
 * Class PostalRepositoryEloquent.
 *
 * @package
 *
 */

class PostalRepositoryEloquent extends BaseRepository implements PostalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Postal::class;
    }
}
