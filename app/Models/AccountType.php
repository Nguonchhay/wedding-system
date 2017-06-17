<?php

namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use SoftDeletes, IdTrait;

	public $timestamps = FALSE;
	public $table = 'account_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'wedding_count'
    ];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id' => 'string'
	];

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public static $rules = [
		'name' => 'required|min:3',
		'wedding_count' => 'numeric'
	];


	public function accounts() {
		return $this->hasMany('App\Models\Account');
	}
}
