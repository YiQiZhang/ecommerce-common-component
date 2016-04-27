<?php

namespace TechTree\Ecommerce\Cart\Interfaces;

use TechTree\Ecommerce\Cart\Contracts\CartContract;
use TechTree\Ecommerce\Cart\Contracts\CartItemContract;
use TechTree\Ecommerce\Cart\Contracts\CounterFilterContract;
use TechTree\Ecommerce\Cart\Models\Counter;

abstract class AbstractCart implements CartContract
{
    /**
     * 购物车保存时间
     *
     * @return int
     */
    abstract protected function ttl();

    /**
     * 是否已经登录
     *
     * @return bool
     */
    abstract protected function isLogin();

    /**
     * 已登录时的唯一识别串
     *
     * @return string
     */
    abstract protected function loginUniqueKey();

    /**
     * 未登录时的唯一识别串
     *
     * @return string
     */
    abstract protected function guestUniqueKey();

    /**
     * 将购物车当前状态存储到storage中的购物车
     *
     * @param string $cartUniqueKey
     */
    public function save($cartUniqueKey = '')
    {
        if (empty($cartUniqueKey)) {
            $cartUniqueKey = $this->uniqueKey();
        }
        $this->storage()->save($cartUniqueKey, serialize($this->items()), $this->ttl());
    }

    /**
     * 更新一个购物车项的数量
     *
     * @param string $itemUniqueKey
     * @param int    $quantity
     *
     * @return bool
     */
    public function updateQuantity($itemUniqueKey, $quantity)
    {
        if ($this->hasItem($itemUniqueKey)) {
            $res = $this->item($itemUniqueKey)->updateQuantity($quantity);
            $this->save();

            return $res;
        } else {
            return false;
        }
    }

    /**
     * 选中或不选一个购物车项
     *
     * @param string $uniqueKey
     * @param bool   $status
     *
     * @return bool
     */
    public function select($uniqueKey, $status = true)
    {
        if ($this->hasItem($uniqueKey)) {
            $res = $this->item($uniqueKey)->select($status);
            $this->save();

            return $res;
        } else {
            return false;
        }
    }

    /**
     * 和另外一个购物车合并
     *
     * @param CartContract $anotherCart
     */
    public function merge(CartContract $anotherCart)
    {
        /** @var CartItemContract $item */
        foreach ($anotherCart->items() as $item) {
            $this->put($item);
        }
        $this->save();
    }

    /**
     * 购物车唯一标识
     *
     * @return string
     */
    public function uniqueKey()
    {
        if ($this->isLogin()) {
            $uniqueKey = $this->loginUniqueKey();
        } else {
            $uniqueKey = $this->guestUniqueKey();
        }

        return md5(sprintf('cart:%s', $uniqueKey));
    }

    /**
     * 是否有一个购物车项
     *
     * @param string $itemUniqueKey
     *
     * @return bool
     */
    public function hasItem($itemUniqueKey)
    {
        return $this->item($itemUniqueKey) ? true : false;
    }

    /**
     * 获取一个购物车项的数量
     *
     * @param $itemUniqueKey
     *
     * @return int
     */
    public function quantity($itemUniqueKey)
    {
        /** @var CartItemContract $item */
        $item = $this->item($itemUniqueKey);

        return ($item) ? $item->quantity() : 0;
    }

    /**
     * 是否选中一个购物车项
     *
     * @param string $itemUniqueKey
     *
     * @return bool
     */
    public function isSelected($itemUniqueKey)
    {
        /** @var CartItemContract $item */
        $item = $this->item($itemUniqueKey);

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
        foreach ($this->items($onlySelected) as $item) {
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
        foreach ($this->items($onlySelected) as $item) {
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
        foreach ($this->items($onlySelected) as $item) {
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
        foreach ($this->items($onlySelected) as $item) {
            $categoryIds = array_merge($categoryIds, $item->categoryIds());
        }

        return array_unique($categoryIds);
    }

    /**
     * 购物车展示数据
     *
     * @param bool|false              $onlySelected
     * @param CounterFilterContract[] $filters
     *
     * @return mixed
     */
    public function output($onlySelected = false, $filters = [])
    {
        $counter = new Counter($this->items($onlySelected));
        foreach ($filters as $filter) {
            $filter->filter($counter);
        }

        return $counter->checkout();
    }
}
