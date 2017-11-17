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
        $dollar = DB::table('expense_details')
            ->select(DB::raw('sum(total) as total'))
            ->where('currency', '=', 'dollar')
            ->where('expense_id', '=', $id)
            ->limit(1)
            ->first();

        $khmer = DB::table('expense_details')
            ->select(DB::raw('sum(total) as total'))
            ->where('currency', '=', 'khmer')
            ->where('expense_id', '=', $id)
            ->limit(1)
            ->first();

        $totalExpense = [
            'dollar' => floatval($dollar->total),
            'khmer' => intval($khmer->total)
        ];

        return $totalExpense;
    }
}
