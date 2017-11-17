<?php

namespace App\Repositories;

use App\Models\Guest;
use InfyOm\Generator\Common\BaseRepository;

class GuestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_name',
        'print_name',
        'note',
        'dollar',
        'khmer'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Guest::class;
    }
}
