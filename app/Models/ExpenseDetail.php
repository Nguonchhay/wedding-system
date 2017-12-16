<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

class ExpenseDetail extends Model
{
    use IdTrait;

    public $table = 'expense_details';

    public $fillable = [
        'expense_id',
        'date',
        'who',
        'dollar',
        'khmer',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'expense_id' => 'string',
        'dollar' => 'float',
        'khmer' => 'numeric'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'expense_id' => 'required',
        'date' => 'required'
    ];

    public function expense()
    {
        return $this->belongsTo('App\Models\Expense');
    }
}
