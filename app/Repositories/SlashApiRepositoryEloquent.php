<?php

namespace App\Repositories;
use App\Models\SlashApi;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Enums\AdminAccountStatus;
/**
 * Class SlashApiRepositoryEloquent.
 *
 * @package
 *
 */

class SlashApiRepositoryEloquent extends BaseRepository implements SlashApiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SlashApi::class;
    }
}
