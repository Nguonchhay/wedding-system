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
        'guest_group_id',
        'khmer_name',
        'english_name',
        'phone',
        'print_name',
        'address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'guest_group_id' => 'string',
        'user_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'guest_group_id' => 'required'
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

    /**
     * @return mixed
     */
    public function wedding_invitations() {
        return $this->hasMany('App\Models\WeddingInvitation');
    }
}
