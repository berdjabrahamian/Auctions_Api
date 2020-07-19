<?php

namespace App\Model\Store;

use App\Model\Auction\Auction;
use App\Model\Auction\Log;
use App\Model\Customer\Customer;
use App\Model\Product\Product;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected        $table        = 'stores';
    public           $timestamps   = TRUE;
    protected        $hidden       = [
        'public_key',
        'secret_key',
    ];
    protected        $attributes   = [
        'ending_soon_notification' => 5,
    ];
    protected static $currentStore = NULL;
    protected static $publicKey    = NULL;
    protected static $secretKey    = NULL;


    public function auctions()
    {
        return $this->hasMany(Auction::class, 'store_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'store_id', 'id');
    }

    public function logs() {
        return $this->hasMany(Log::class, 'store_id', 'id');
    }


    public function buyersPremiumPrice($amount)
    {
        $storeHammerPrice = $this->hammer_price;
        $storeHammerType  = $this->hammer_type;

        if ($storeHammerType == 0) {
            return ($amount * ($storeHammerPrice / 100)) + $amount;
        } else {
            return $amount + $storeHammerPrice;
        }
    }

    public static function endingSoonThreshold(Auction $auction)
    {
        $store   = $auction->store;
        $endDate = $auction->end_date;
        $time    = $store->ending_soon_notification;

        $endTime = $endDate->subHours($time);

        return $endTime;
    }

    /**
     * @param  mixed  $currentStore
     */
    public static function setCurrentStore(): void
    {

        self::setPublicKey();
        self::setSecretKey();

        $store = self::$secretKey ? Store::where('secret_key', self::$secretKey) : Store::where('public_key',
            self::$publicKey);

        $store = $store->firstOrFail();

        self::$currentStore = $store;

        return;
    }

    /**
     * @return mixed
     */
    public static function getCurrentStore()
    {
        return self::$currentStore;
    }

    /**
     * @return null
     */
    public static function getPublicKey()
    {
        return self::$publicKey;
    }

    /**
     * @param  null  $publicKey
     */
    public static function setPublicKey(): void
    {
        $publicKey = Request()->header('X-Public-Key') ? Request()->header('X-Public-Key') : Request()->input('public-key');

        self::$publicKey = $publicKey;
    }

    /**
     * @return null
     */
    public static function getSecretKey()
    {
        return self::$secretKey;
    }

    /**
     * @param  null  $secretKey
     */
    public static function setSecretKey(): void
    {
        $secretKey = Request()->header('X-Secret-Key') ? Request()->header('X-Secret-Key') : Request()->input('secret-key');

        self::$secretKey = $secretKey;
    }

}
