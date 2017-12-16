<?php

namespace App\Repositories;

use App\Models\ExpenseDetail;
use InfyOm\Generator\Common\BaseRepository;
use DB;

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

    /**
     * @param string $id
     * @return array
     */
    public function getTotalExpenseDetailsByExpense($id)
    {
        $queryExpenseDetail = DB::table('expense_details')
            ->select(DB::raw('sum(dollar) as total_dollar'), DB::raw('sum(khmer) as total_khmer'))
            ->join('expenses', 'expenses.id', 'expense_details.expense_id')
            ->where('expense_id', '=', $id)
            ->first();

        $totalExpenseDetail = [
            'total_dollar' => $queryExpenseDetail->total_dollar,
            'total_khmer' => $queryExpenseDetail->total_khmer
        ];

        return $totalExpenseDetail;
    }
}
