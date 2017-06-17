<?php

namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes, IdTrait;

    public $table = 'accounts';
    protected $dates = ['deleted_at'];
	public $timestamps = FALSE;

    public $fillable = [
		'user_id',
		'account_type_id',
        'sex',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
		'id' => 'string',
		'user_id' => 'string',
		'account_type_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
		'user_id' => 'required',
        'account_type_id' => 'required'
    ];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function account_type() {
		return $this->belongsTo('App\Models\AccountType');
	}
}
