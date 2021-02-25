<?php


namespace App\Traits;


use Hidehalo\Nanoid\Client;

trait PublicId
{
    protected static function bootPublicId() {
        static::creating(function ($model){
            $model->pub_id = (new Client())->formatedId('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 14);

        });
    }
}
