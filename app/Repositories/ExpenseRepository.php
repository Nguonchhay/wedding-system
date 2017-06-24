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

	/**
	 * @param string $id
	 * @return array
	 */
	public function getTotalExpenseByWedding($id)
	{
		$dollar = DB::table('expenses')
			->select(DB::raw('sum(total) as total'))
			->where('currency', '=', 'dollar')
			->where('wedding_id', '=', $id)
			->limit(1)
			->first();

		$khmer = DB::table('expenses')
			->select(DB::raw('sum(total) as total'))
			->where('currency', '=', 'khmer')
			->where('wedding_id', '=', $id)
			->limit(1)
			->first();

		$totalExpense = [
			'dollar' => floatval($dollar->total),
			'khmer' => intval($khmer->total)
		];

		return $totalExpense;
	}
}
