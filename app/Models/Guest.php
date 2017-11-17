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
        'user_id',
        'full_name',
        'print_name',
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
        'user_id' => 'required',
        'full_name' => 'required|min:3'
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return mixed
     */
    public function guest_group()
    {
        return $this->belongsTo('App\Models\GuestGroup');
    }
}
