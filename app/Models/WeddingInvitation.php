<?php

namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeddingInvitation extends Model
{
    use SoftDeletes, IdTrait;

    public $table = 'wedding_invitations';
    protected $dates = ['deleted_at'];
	public $timestamps = FALSE;

    public $fillable = [
		'user_id',
		'wedding_id',
        'guest_id',
		'print_name',
		'dowry',
        'dollar',
        'khmer',
        'bat',
        'dong',
		'other',
		'record_from',
		'code',
		'qrcode'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
		'id' => 'string',
        'guest_id' => 'string',
		'wedding_id' => 'string',
        'user_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
		'guest_id' => 'required',
		'wedding_id' => 'required',
		'user_id' => 'required',
        'dollar' => 'numeric',
        'khmer' => 'numeric',
		'bat' => 'numeric',
		'dong' => 'numeric'
    ];
}
