<?php

namespace App\Repositories;

use App\Models\Account;
use InfyOm\Generator\Common\BaseRepository;

class AccountRepository extends BaseRepository {

	/**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'role'
    ];

    /**
     * Configure the Model
     **/
    public function model() {
        return Account::class;
    }
}
