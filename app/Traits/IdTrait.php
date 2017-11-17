<?php
namespace App\Traits;

/**
 *  This class is belong to Reasie
 *
 *  It is used to generate auto id with uuid
 */

use Ramsey\Uuid\Uuid;

trait IdTrait {

    /**
     * Boot the Uuid trait for the model.
     *
     * @return void
     */
    public static function bootIdTrait() {
        static::creating(function($model) {
            $model->incrementing = false;
            $uuid = str_replace('-', '', Uuid::uuid1()->toString());
            $model->{$model->getKeyName()} = $uuid;
        });
    }
}