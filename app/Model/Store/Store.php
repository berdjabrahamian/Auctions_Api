<?php

namespace App\Model\Store;

use App\Model\Customer\Customer;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected        $table        = 'stores';
    public           $timestamps   = true;
    protected static $currentStore = null;
    protected static $publicKey    = null;
    protected static $secretKey    = null;


    /**
     * @param  mixed  $currentStore
     */
    public static function setCurrentStore(): void
    {
        self::setPublicKey();
        self::setSecretKey();

        $store = self::$secretKey ? Store::where('secret_key', self::$secretKey) : Store::where('public_key',
            self::$publicKey);

        $store = $store->firstOrFail(['id']);

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
