<?php

namespace TechTree\Ecommerce\Cart\Models;

use TechTree\Ecommerce\Cart\Contracts\CartItemContract;
use TechTree\Ecommerce\Cart\Models\Cart\Cart;
use TechTree\Ecommerce\Cart\Providers\TemporaryStorageProvider;

class Counter
{
    protected $tempCart;

    /**
     * @param CartItemContract[] $items
     */
    public function __construct($items)
    {
        $this->tempCart = new Cart(new TemporaryStorageProvider());
        foreach($items as $item) {
            $this->tempCart->put($item);
        }
    }

    /********************************** 修改方法 **************************/

    /**
     * @param string[] $itemUniqueKeys
     */
    public function singleItemToMultiItem($itemUniqueKeys)
    {

    }

    /**
     * @param string $itemUniqueKey
     */
    public function multiItemToSingleItem($itemUniqueKey)
    {

    }

    /********************************** 查询方法 **************************/

    public function cart()
    {
        return $this->tempCart;
    }

    public function count()
    {
        return $this->tempCart->count();
    }

    public function total()
    {
        $total = 0.00;
        foreach($this->tempCart->items() as $item) {
            $total += $item->price() * $item->quantity();
        }

        return $total;
    }

    public function totalPoint()
    {
        $point = 0;
        foreach($this->tempCart->items() as $item) {
            $point += $item->point() * $item->quantity();
        }

        return $point;
    }

    public function checkout()
    {
        $return = [
            'total' => $this->total(),
            'count' => $this->count(),
            'totalPoint' => $this->totalPoint(),
            'items' => [],
        ];
        foreach($this->tempCart->items() as $item) {
            $return['items'][] = $item->output();
        }

        return $return;
    }
}