<?php

namespace App\Repositories;

use App\Models\MerchantToken;
use App\Validators\Merchant\MerchantValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class MerchantRepositoryEloquent.
 *
 * @package namespace App\Repositories\Merchant;
 */
class MerchantTokenRepositoryEloquent extends BaseRepository implements MerchantTokenRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MerchantToken::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MerchantValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

   /**
    * @param $email
    * @return mixed
    */
   public function findMerchantToken($data)
   {
       return $this->model
           ->where('token', $data['token'])
           ->where('email', $data['email'])
           ->first();
   }

}
