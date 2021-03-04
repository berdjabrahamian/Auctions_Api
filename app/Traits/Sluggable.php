<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait Sluggable
{
    protected static function bootSluggable() {
        static::creating(function ($model){
            $model->slug = Str::slug($model->name);
        });
    }
}
