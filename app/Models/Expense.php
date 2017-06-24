<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

class Expense extends Model
{
    use IdTrait;

    public $table = 'expenses';

    public $fillable = [
		'wedding_id',
        'title',
        'total',
		'currency',
		'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
		'wedding_id' => 'string',
        'total' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
		'wedding_id' => 'required',
        'title' => 'required',
		'total' => 'required'
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
}
