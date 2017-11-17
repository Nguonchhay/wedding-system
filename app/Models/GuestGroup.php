<?php

namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

class GuestGroup extends Model
{
    use IdTrait;

    public $table = 'guest_groups';
    public $timestamps = FALSE;

    public $fillable = [
        'name',
        'short_name'
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
        'name' => 'required'
    ];

    /**
     * @return mixed
     */
    public function guests() {
        return $this->hasMany('App\Models\Guest');
    }
}
