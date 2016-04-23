<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use TechTree\Ecommerce\Cart\Interfaces\Promotable;

interface CartItemDetailContract extends Promotable
{
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
     * 固有数量单位
     *
     * @return int
     */
    public function quantity();

    /**
     * 原价
     *
     * @return float
     */
    public function originalPrice();

    /**
     * 单价
     *
     * @return float
     */
    public function price();

    /**
     * 总价
     *
     * @return float
     */
    public function total();
}