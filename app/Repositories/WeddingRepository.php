<?php
namespace App\Repositories;

use App\Models\Wedding;
use InfyOm\Generator\Common\BaseRepository;

class WeddingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'groom_name',
        'bride_name',
        'groom_image',
        'bride_image',
        'start_date',
        'end_date',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Wedding::class;
    }
}
