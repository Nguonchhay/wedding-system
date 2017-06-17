<?php

namespace App\Models;

use App\Traits\IdTrait;
use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="Expense",
 *      required={"title"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="dollar",
 *          description="dollar",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="khmer",
 *          description="khmer",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Expense extends Model
{
    use IdTrait;

    public $table = 'expenses';

    public $fillable = [
        'title',
        'dollar',
        'khmer'
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
