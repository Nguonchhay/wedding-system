<?php
namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

class Expense extends Model
{
    use IdTrait;

    public $table = 'expenses';

    public $fillable = [
        'title',
        'dollar',
        'khmer',
		'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'dollar' => 'float',
        'khmer' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];
}
