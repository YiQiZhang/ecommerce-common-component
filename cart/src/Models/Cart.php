<?php

namespace TechTree\Ecommerce\Cart\Models;

use TechTree\Ecommerce\Cart\Contracts\CartContract;
use Illuminate\Support\Collection;
use TechTree\Ecommerce\Cart\Contracts\CartItemContract;
use TechTree\Ecommerce\Cart\Contracts\StorageProviderContract;

class Cart implements CartContract
{
    /**
     * @var StorageProviderContract
     */
    protected $storage;

    /**
     * @var Collection 内含CartItemContract
     */
    protected $items;

    public function __construct(StorageProviderContract $provider)
    {
        $this->storage = $provider;
        $this->item = new Collection();
    }

    /********************************** 修改方法(会修改购物车) **************************/

    /**
     * 加入一个购物车项
     *
     * @param CartItemContract $cartItem
     *
     * @return bool
     */
    public function put(CartItemContract $cartItem)
    {
        $itemKey = $cartItem->uniqueKey();
        if ($this->hasItem($itemKey)) {
            $originalCartItem = $this->item($itemKey);
            $originalCartItem->updateQuantity($originalCartItem->quantity() + $cartItem->quantity());
            $originalCartItem->select(true);
        } else {
            $this->items->put($itemKey, $cartItem);
        }

        return true;
    }

    /**
     * 更新一个购物车项的数量
     *
     * @param string $uniqueKey
     * @param int $quantity
     *
     * @return bool
     */
    public function updateQuantity($uniqueKey, $quantity)
    {
        if ($this->hasItem($uniqueKey)) {
            return $this->item($uniqueKey)->updateQuantity($quantity);
        } else {
            return false;
        }
    }

    /**
     * 选中或不选一个购物车项
     *
     * @param string $uniqueKey
     * @param bool $status
     *
     * @return bool
     */
    public function select($uniqueKey, $status = true)
    {
        if ($this->hasItem($uniqueKey)) {
            return $this->item($uniqueKey)->select($status);
        } else {
            return false;
        }
    }

    /**
     * 移除一个或多个购物车项
     *
     * @param string|string[] $uniqueKeys
     *
     * @return bool
     */
    public function remove($uniqueKeys)
    {
        if (!is_array($uniqueKeys)) {
            $uniqueKeys = [$uniqueKeys];
        }

        return $this->items->forget($uniqueKeys);
    }

    /**
     * 清空购物车
     *
     * @return bool
     */
    public function clear()
    {
        $this->items = new Collection();
    }

    /**
     * 和另外一个购物车合并
     *
     * @param CartContract $anotherCart
     *
     * @return void
     */
    public function merge(CartContract $anotherCart)
    {
        /** @var CartItemContract $item */
        foreach($anotherCart->items() as $item) {
            $this->put($item);
        }
    }

    /********************************** 查询方法(不会变更购物车) **************************/
    /**
     * 购物车唯一标识
     *
     * @return string
     */
    public function uniqueKey()
    {
        $isLogin = true;

        if ($isLogin) {
            $loginUniqueId = 0;
            $uniqueKey = $loginUniqueId;
        } else {
            $sessionKey = '';
            $uniqueKey = $sessionKey;
        }

        return md5(sprintf('cart:%s', $uniqueKey));
    }

    /**
     * 是否有一个购物车项
     *
     * @param string $uniqueKey
     *
     * @return bool
     */
    public function hasItem($uniqueKey)
    {
        return $this->item($uniqueKey) ? true : false;
    }

    /**
     * 获取一个购物车项的数量
     *
     * @param $uniqueKey
     *
     * @return int
     */
    public function quantity($uniqueKey)
    {
        /** @var CartItemContract $item */
        $item = $this->item($uniqueKey);

        return ($item) ? $item->quantity() : 0;
    }

    /**
     * 是否选中一个购物车项
     *
     * @param string $uniqueKey
     *
     * @return bool
     */
    public function isSelected($uniqueKey)
    {
        /** @var CartItemContract $item */
        $item = $this->item($uniqueKey);

        return ($item) ? $item->isSelected() : false;
    }

    /**
     * 购物车项总数量
     *
     * @param bool $onlySelected
     *
     * @return int
     */
    public function itemCount($onlySelected = false)
    {
        $count = 0;
        foreach($this->items($onlySelected) as $item) {
            $count += $item->quantity();
        }

        return $count;
    }

    /**
     * 商品总数量
     *
     * @param bool $onlySelected
     *
     * @return int
     */
    public function count($onlySelected = false)
    {
        $count = 0;
        foreach($this->items($onlySelected) as $item) {
            $count += ($item->quantity() * $item->goodsCount());
        }

        return $count;
    }

    /**
     * 购物车内包含的所有商品的id
     *
     * @param bool $onlySelected
     *
     * @return array
     */
    public function goodsIds($onlySelected = false)
    {
        $goodsIds = [];
        foreach($this->items($onlySelected) as $item) {
            $goodsIds = array_merge($goodsIds, $item->goodsIds());
        }

        return array_unique($goodsIds);
    }

    /**
     * 购物车内包含的所有商品的目录id
     *
     * @param bool $onlySelected
     *
     * @return array
     */
    public function categoryIds($onlySelected = false)
    {
        $categoryIds = [];
        foreach($this->items($onlySelected) as $item) {
            $categoryIds = array_merge($categoryIds, $item->categoryIds());
        }

        return array_unique($categoryIds);
    }

    /**
     * 购物车展示数据
     *
     * @param bool|false $onlySelected
     *
     * @return mixed
     */
    public function output($onlySelected = false)
    {

    }

    /**
     * 购物车结算数据
     *
     * @param bool|true $onlySelected
     *
     * @return mixed
     */
    public function checkout($onlySelected = true)
    {

    }

    /********************************** 查询且有可能修改方法 **************************/
    /**
     * @param bool|false $onlySelected
     *
     * @return CartItemContract[]
     */
    public function items($onlySelected = false)
    {
        if ($onlySelected) {
            $items = new Collection();
            /** @var CartItemContract $item */
            foreach($this->items as $item) {
                if ($item->isSelected()) {
                    $items->put($item->uniqueKey(), $item);
                }
            }

            return $items;
        } else {
            return $this->items;
        }
    }

    public function item($itemKey)
    {
        return $this->items->get($itemKey, false);
    }
}