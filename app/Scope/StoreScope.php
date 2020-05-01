<?php


namespace App\Scope;


use App\Model\Store\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StoreScope implements Scope
{
    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->addSelect('auctions.* as auctions')->where("{$model->getTable()}.store_id", '=',
            Store::getCurrentStore()->id);
    }
}
