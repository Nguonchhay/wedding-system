<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

class WeddingInvitation extends Model
{
    use IdTrait;

    public $table = 'wedding_invitations';
    public $timestamps = FALSE;

    public $fillable = [
        'wedding_id',
        'guest_id',
        'dollar',
        'khmer',
        'other',
        'record_from'
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
        'dollar' => 'double',
        'khmer' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'guest_id' => 'required',
        'wedding_id' => 'required'
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
    public function guest()
    {
        return $this->belongsTo('App\Models\Guest');
    }

    /**
     * @return bool
     */
    public function hasGift()
    {
        $has = false;
        if ($this->dollar > 0 || $this->khmer > 0 || $this->other != '') {
            $has = true;
        }
        return $has;
    }

    /**
     * @return bool
     */
    public function noGift()
    {
        $has = false;
        if ($this->dollar == 0 && $this->khmer == 0 && $this->other == '') {
            $has = true;
        }
        return $has;
    }
}
