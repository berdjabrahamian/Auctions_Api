<?php

namespace App\Model\Store;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'store_options';
    public $timestamps = true;


    protected $fillable = ['customer_data_hidden'];
    protected $attributes = [
      'customer_data_hidden' => false,
    ];


    public function store() {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
