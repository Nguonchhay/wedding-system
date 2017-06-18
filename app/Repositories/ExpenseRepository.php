<?php
namespace App\Repositories;

use App\Models\Expense;
use InfyOm\Generator\Common\BaseRepository;
use DB;

class ExpenseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'dollar',
        'khmer'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Expense::class;
    }

	public function getTotalExpenseByWedding($id)
	{
		return DB::table('expenses')
			->select(DB::raw('sum(dollar) as total_dollar'), DB::raw('sum(khmer) as total_khmer'))
			->where('wedding_id', '=', $id)
			->limit(1)
			->first();
	}
}
