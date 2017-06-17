<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use SoftDeletes, IdTrait;

    public $table = 'guests';
    protected $dates = ['deleted_at'];
	public $timestamps = FALSE;

    public $fillable = [
		'created_by',
        'fullname',
        'print_name',
        'address',
		'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
		'id' => 'string',
		'created_by' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
		'created_by' => 'required',
        'fullname' => 'required|min:3'
    ];
}
