<?php

namespace App\Repositories;

use App\Models\AccountType;
use InfyOm\Generator\Common\BaseRepository;

class AccountTypeRepository extends BaseRepository {

	/**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'wedding_count'
    ];

    /**
     * Configure the Model
     **/
    public function model() {
        return AccountType::class;
    }
}
