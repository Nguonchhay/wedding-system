<?php
namespace App\Models;

use App\Repositories\ExpenseDetailRepository;
use App\Traits\IdTrait;
use Eloquent as Model;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    use IdTrait;

    public $table = 'expenses';

    public $fillable = [
        'wedding_id',
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'wedding_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'wedding_id' => 'required',
        'title' => 'required'
    ];

    /**
     * @return mixed
     */
    public function wedding()
    {
        return $this->belongsTo('App\Models\Wedding');
    }

    /**
     * @return mixed
     */
    public function expense_details()
    {
        return $this->hasMany('App\Models\ExpenseDetail');
    }

    /**
     * @return array
     */
    public function getTotalExpense()
    {
        /** @var ExpenseDetailRepository $expenseDetailRepository */
        $expenseDetailRepository = new ExpenseDetailRepository(app());
        return $expenseDetailRepository->getTotalExpenseDetailsByExpense($this->id);
    }
}
