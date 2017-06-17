<?php

namespace App\Repositories;

use App\Models\Wedding;
use App\Models\WeddingInvitation;
use InfyOm\Generator\Common\BaseRepository;

class WeddingInvitationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
		'print_name',
		'dowry',
		'dollar',
		'khmer',
		'bat',
		'dong',
		'other'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WeddingInvitation::class;
    }
}
