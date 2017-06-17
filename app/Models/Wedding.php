<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wedding extends Model
{
    use SoftDeletes, IdTrait;

    public $table = 'weddings';
    protected $dates = ['deleted_at'];
	public $timestamps = FALSE;

    public $fillable = [
        'groom_name',
		'bride_name',
		'groom_image',
		'bride_image',
        'start_date',
        'end_date',
		'note'
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
        'groom' => 'required|min:3',
		'bride' => 'required|min:3',
		'start_date' => 'required',
		'end_date' => 'required'
    ];
}
