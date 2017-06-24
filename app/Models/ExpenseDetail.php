<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="ExpenseDetail",
 *      required={"expense_id", "total", "date", "who"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="expense_id",
 *          description="expense_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="total",
 *          description="total",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="currency",
 *          description="currency",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="who",
 *          description="who",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="note",
 *          description="note",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class ExpenseDetail extends Model
{
    use IdTrait;

    public $table = 'expense_details';

    public $fillable = [
        'expense_id',
        'total',
        'currency',
        'date',
        'who',
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
        'total' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'expense_id' => 'required',
        'total' => 'required',
        'date' => 'required',
        'who' => 'required'
    ];

    public function expense()
	{
		return $this->belongsTo('App\Models\Expense');
	}
}
