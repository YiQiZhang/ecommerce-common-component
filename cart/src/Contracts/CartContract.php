<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use Iterator;

interface CartContract
{
    /********************************** 修改方法(会修改购物车) **************************/

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
     * @param string $uniqueKey
     * @param int $quantity
     *
     * @return bool
     */
    public function updateQuantity($uniqueKey, $quantity);

    /**
     * 选中或不选一个购物车项
     *
     * @param string $uniqueKey
     * @param bool $status
     *
     * @return bool
     */
    public function select($uniqueKey, $status = true);

    /**
     * 移除一个或多个购物车项
     *
     * @param string|string[] $uniqueKey
     *
     * @return bool
     */
    public function remove($uniqueKey);

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
     * 购物车唯一标识
     *
     * @return string
     */
    public function uniqueKey();

    /**
     * 是否有一个购物车项
     *
     * @param string $uniqueKey
     *
     * @return bool
     */
    public function hasItem($uniqueKey);

    /**
     * 获取一个购物车项的数量
     *
     * @param string $uniqueKey
     *
     * @return int
     */
    public function quantity($uniqueKey);

    /**
     * 是否选中一个购物车项
     *
     * @param string $uniqueKey
     *
     * @return bool
     */
    public function isSelected($uniqueKey);

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
     * 购物车展示数据
     *
     * @param bool|false $onlySelected
     *
     * @return mixed
     */
    public function output($onlySelected = false);

    /**
     * 购物车结算数据
     *
     * @param bool|true $onlySelected
     *
     * @return mixed
     */
    public function checkout($onlySelected = true);

    /********************************** 查询且有可能修改方法 **************************/
    /**
     * @param bool|false $onlySelected
     *
     * @return CartItemContract[]
     */
    public function items($onlySelected = false);

    /**
     * @param string $itemKey
     *
     * @return CartItemContract
     */
    public function item($itemKey);
}