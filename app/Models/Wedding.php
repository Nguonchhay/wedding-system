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
        'user_id',
        'title',
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
        'id' => 'string',
        'user_id' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'title' => 'required',
        'groom_name' => 'required|min:3',
        'bride_name' => 'required|min:3',
        'start_date' => 'required',
        'end_date' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return mixed
     */
    public function wedding_invitations() {
        return $this->hasMany('App\Models\WeddingInvitation');
    }

    /**
     * @return mixed
     */
    public function expenses() {
        return $this->hasMany('App\Models\Expense');
    }

    /**
     * @return string
     */
    public static function getBaseImagePath() {
        return config('settings.assets.image');
    }

    /**
     * @return string
     */
    public static function getPrefixImage() {
        return date('GdYsmi');
    }
}
