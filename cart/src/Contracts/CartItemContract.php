<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use TechTree\Ecommerce\Cart\Interfaces\Promotable;

interface CartItemContract extends Promotable
{
    /********************************** 修改方法 **************************/
    /**
     * 更新购物车项数量
     *
     * @param int $quantity
     *
     * @return bool
     */
    public function updateQuantity($quantity);

    /**
     * 更新购物车项选中状态
     *
     * @param $status
     *
     * @return bool
     */
    public function select($status);

    /********************************** 查询方法 **************************/
    /**
     * 唯一标识
     *
     * @return string
     */
    public function uniqueKey();

    /**
     * 该购物车项数量
     *
     * @return int
     */
    public function quantity();

    /**
     * 选中状态
     *
     * @return bool
     */
    public function isSelected();

    /**
     * 标题
     *
     * @return string
     */
    public function title();

    /**
     * 封面图
     *
     * @return string
     */
    public function cover();

    /**
     * 类型
     *
     * @return string
     */
    public function type();

    /**
     * 是否有多个实体在此项中
     *
     * @return bool
     */
    public function isMultiple();

    /**
     * 单位该购物车项的商品数量
     *
     * @return int
     */
    public function goodsCount();

    /**
     * 该购物车项包含的所有商品的id
     *
     * @return array
     */
    public function goodsIds();

    /**
     * 该购物车项包含的所有商品的目录id
     *
     * @return array
     */
    public function categoryIds();

    /**
     * 原价
     *
     * @return float
     */
    public function originalPrice();

    /**
     * 应用所有促销规则后的现价
     *
     * @return float
     */
    public function price();

    /**
     * 应用所有促销规则后的送积分数
     *
     * @return int
     */
    public function point();

    /**
     * @return mixed
     */
    public function output();

    /********************************** 查询修改方法 **************************/
    /**
     * 购物车项的明细
     *
     * @return mixed
     */
    public function detail();
}