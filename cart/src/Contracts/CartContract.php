<?php

namespace TechTree\Ecommerce\Cart\Contracts;

interface CartContract
{
    /********************************** 修改方法(会修改购物车) **************************/
    /**
     * 恢复存储在storage中的购物车
     *
     * @param string $cartUniqueKey
     *
     * @return void
     */
    public function restore($cartUniqueKey = '');

    /**
     * 将购物车当前状态存储到storage中的购物车
     *
     * @param string $cartUniqueKey
     *
     * @return void
     */
    public function save($cartUniqueKey = '');

    /**
     * 加入一个购物车项
     *
     * @param CartItemContract $cartItem
     *
     * @return bool
     */
    public function put(CartItemContract $cartItem);

    /**
     * 更新一个购物车项的数量
     *
     * @param string $itemUniqueKey
     * @param int $quantity
     *
     * @return bool
     */
    public function updateQuantity($itemUniqueKey, $quantity);

    /**
     * 选中或不选一个购物车项
     *
     * @param string $itemUniqueKey
     * @param bool $status
     *
     * @return bool
     */
    public function select($itemUniqueKey, $status = true);

    /**
     * 移除一个或多个购物车项
     *
     * @param string|string[] $itemUniqueKeys
     *
     * @return bool
     */
    public function remove($itemUniqueKeys);

    /**
     * 清空购物车
     *
     * @return bool
     */
    public function clear();

    /**
     * 和另外一个购物车合并
     *
     * @param CartContract $anotherCart
     *
     * @return void
     */
    public function merge(CartContract $anotherCart);

    /********************************** 查询方法(不会变更购物车) **************************/
    /**
     * @return StorageProviderContract
     */
    public function storage();

    /**
     * 购物车唯一标识
     *
     * @return string
     */
    public function uniqueKey();

    /**
     * 是否有一个购物车项
     *
     * @param string $itemUniqueKey
     *
     * @return bool
     */
    public function hasItem($itemUniqueKey);

    /**
     * 获取一个购物车项的数量
     *
     * @param string $itemUniqueKey
     *
     * @return int
     */
    public function quantity($itemUniqueKey);

    /**
     * 是否选中一个购物车项
     *
     * @param string $itemUniqueKey
     *
     * @return bool
     */
    public function isSelected($itemUniqueKey);

    /**
     * 购物车项总数量
     *
     * @param bool $onlySelected
     *
     * @return int
     */
    public function itemCount($onlySelected = false);

    /**
     * 商品总数量
     *
     * @param bool $onlySelected
     *
     * @return int
     */
    public function count($onlySelected = false);

    /**
     * 购物车内包含的所有商品的id
     *
     * @param bool $onlySelected
     *
     * @return array
     */
    public function goodsIds($onlySelected = false);

    /**
     * 购物车内包含的所有商品的目录id
     *
     * @param bool $onlySelected
     *
     * @return array
     */
    public function categoryIds($onlySelected = false);

    /**
     * 购物车数据输出
     *
     * @param bool|false $onlySelected
     * @param FilterContract[] $filters
     *
     * @return mixed
     */
    public function output($onlySelected = false, $filters = []);

    /********************************** 查询且有可能修改方法 **************************/
    /**
     * @param bool|false $onlySelected
     *
     * @return CartItemContract[]
     */
    public function items($onlySelected = false);

    /**
     * @param string $itemUniqueKey
     *
     * @return CartItemContract
     */
    public function item($itemUniqueKey);
}