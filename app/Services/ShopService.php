<?php

namespace App\Services;

use App\Eloquents\Shop;

class ShopService
{
    public function index()
    {
        $query = Shop::query();
        return $query->get();
    }

    public function findOrFail(int $shopId)
    {
        return Shop::findOrFail($shopId);
    }

    public function create(array $attributes)
    {
        $shop = new Shop();
        $shop->fill($attributes);
        $shop->save();

        return $shop;
    }

    public function update(Shop $arg_shop, array $attributes)
    {
        $shop = clone $arg_shop;
        $shop->fill($attributes);
        $shop->save();

        return $shop;
    }

    public function delete(Shop $shop)
    {
        $shop->delete();
    }
}

?>
