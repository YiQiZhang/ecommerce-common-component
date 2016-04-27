<?php

namespace TechTree\Ecommerce\Cart\Models\Cart;

use Illuminate\Support\Collection;
use TechTree\Ecommerce\Cart\Contracts\CartItemContract;
use TechTree\Ecommerce\Cart\Contracts\StorageProviderContract;
use TechTree\Ecommerce\Cart\Interfaces\AbstractCart;

class Cart extends AbstractCart
{
    /**
     * @var StorageProviderContract
     */
    protected $storage;

    /**
     * @var Collection 内含CartItemContract
     */
    protected $items;

    /**
     * 购物车保存时间
     *
     * @return int
     */
    protected function ttl()
    {
        return 0;
    }

    /**
     * 是否已经登录
     *
     * @return bool
     */
    protected function isLogin()
    {
        return true;
    }

    /**
     * 已登录时的唯一识别串
     *
     * @return string
     */
    protected function loginUniqueKey()
    {
        return '';
    }

    /**
     * 未登录时的唯一识别串
     *
     * @return string
     */
    protected function guestUniqueKey()
    {
        return '';
    }

    public function __construct(StorageProviderContract $provider)
    {
        $this->storage = $provider;
        $this->items = new Collection();
    }

    /**
     * 恢复存储在storage中的购物车
     *
     * @param string $cartUniqueKey
     */
    public function restore($cartUniqueKey = '')
    {
        if (empty($cartUniqueKey)) {
            $cartUniqueKey = $this->uniqueKey();
        }

        $itemsData = $this->storage()->restore($cartUniqueKey);
        $this->items = unserialize($itemsData);
    }

    /**
     * 加入一个购物车项
     *
     * @param CartItemContract $cartItem
     *
     * @return bool
     */
    public function put(CartItemContract $cartItem)
    {
        $itemUniqueKey = $cartItem->uniqueKey();
        if ($this->hasItem($itemUniqueKey)) {
            $originalCartItem = $this->item($itemUniqueKey);
            $originalCartItem->updateQuantity($originalCartItem->quantity() + $cartItem->quantity());
            $originalCartItem->select(true);
        } else {
            $this->items->put($itemUniqueKey, $cartItem);
        }

        $this->save();

        return true;
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

        $this->items->forget($uniqueKeys);
        $this->save();

        return true;
    }

    /**
     * 清空购物车
     *
     * @return bool
     */
    public function clear()
    {
        $this->items = new Collection();
        $this->save();

        return true;
    }

    /********************************** 查询方法(不会变更购物车) **************************/

    /**
     * @return StorageProviderContract
     */
    public function storage()
    {
        return $this->storage();
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
            foreach ($this->items as $item) {
                if ($item->isSelected()) {
                    $items->put($item->uniqueKey(), $item);
                }
            }

            return $items;
        } else {
            return $this->items;
        }
    }

    public function item($itemUniqueKey)
    {
        return $this->items->get($itemUniqueKey, false);
    }
}
