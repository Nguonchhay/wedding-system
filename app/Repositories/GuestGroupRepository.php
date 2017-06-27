<?php

namespace App\Repositories;

use App\Models\GuestGroup;
use InfyOm\Generator\Common\BaseRepository;

class GuestGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'short_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GuestGroup::class;
    }
}
