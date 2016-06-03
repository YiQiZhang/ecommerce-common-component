<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use TechTree\Ecommerce\Cart\Interfaces\CartItemType;
use TechTree\Ecommerce\Cart\Interfaces\Promotable;

interface CartItemContract extends Promotable, CartItemType
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
     * @param bool $status
     *
     * @return bool
     */
    public function select($status);

    /**
     * 重新刷新模型
     *
     * @return void
     */
    public function renew();

    /********************************** 查询方法 **************************/
    /**
     * 是否可选中,修改数量
     *
     * @return bool
     */
    public function modifiable();

    /**
     * 唯一标识
     *
     * @return string
     */
    public function uniqueKey();

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
     * 此购物车项是否还在生效
     *
     * @return bool
     */
    public function onsale();

    /**
     * 是否有多个实体在此项中
     *
     * @return bool
     */
    public function isMultiple();

    /**
     * 选中状态
     *
     * @return bool
     */
    public function isSelected();

    /**
     * 是否购物车中原始的商品, 还是经过filter之后生成的商品
     *
     * @return bool
     */
    public function isOriginal();

    /**
     * 该购物车项是否含有虚拟商品
     *
     * @return bool
     */
    public function hasVirtualDetail();

    /**
     * 该购物车项数量
     *
     * @return int
     */
    public function quantity();

    /**
     * 单位该购物车项的商品数量
     *
     * @return int
     */
    public function goodsCount();

    /**
     * 该购物车项包含的所有goods的id
     *
     * @return array
     */
    public function goodsIds();

    /**
     * 该购物车项包含的所有goods_sku的id
     *
     * @return array
     */
    public function goodsSkuIds();

    /**
     * 该购物车项包含的所有product的id
     *
     * @return array
     */
    public function productIds();

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
     * @return array
     */
    public function output();

    /********************************** 查询修改方法 **************************/
    /**
     * 购物车项的明细
     *
     * @return CartItemDetailContract|CartItemContract[]
     */
    public function detail();
}