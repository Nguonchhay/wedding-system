<?php

namespace App\Repositories;

use App\Models\ExpenseDetail;
use InfyOm\Generator\Common\BaseRepository;

class ExpenseDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'expense_id',
        'total',
        'currency',
        'date',
        'who',
        'note'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExpenseDetail::class;
    }
}
