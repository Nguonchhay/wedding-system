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
        $queryExpense = DB::table('expense_details')
            ->select(DB::raw('sum(dollar) as total_dollar'), DB::raw('sum(khmer) as total_khmer'))
            ->join('expenses', 'expenses.id', 'expense_details.expense_id')
            ->where('wedding_id', '=', $id)
            ->first();

        $totalExpense = [
            'total_dollar' => $queryExpense->total_dollar,
            'total_khmer' => $queryExpense->total_khmer
        ];

        return $totalExpense;
    }
}
