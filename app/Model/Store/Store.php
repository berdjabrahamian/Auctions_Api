<?php

namespace App\Model\Store;

use App\Model\Auction\Auction;
use App\Model\Customer\Customer;
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
