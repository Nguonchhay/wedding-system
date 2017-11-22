<?php

namespace App;

use App\Traits\IdTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, IdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'password', 'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
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
        'name' => 'required|min:3',
        'email' => 'required',
        'role' => 'required'
    ];

    /**
     * @return mixed
     */
    public function weddings() {
        return $this->hasMany('App\Models\Wedding');
    }

    /**
     * @return mixed
     */
    public function guests() {
        return $this->hasMany('App\Models\Guest');
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return ($this->role === $role) ? true : false;
    }

    /**
     * @return User|null
     */
    public function getCreatedByUser()
    {
        return User::where('created_by', $this->created_by)->first();
    }
}
