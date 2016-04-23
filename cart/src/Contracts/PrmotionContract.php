<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use TechTree\Ecommerce\Cart\Interfaces\PromotionType;

interface PromotionContract extends PromotionType
{
    /**
     * 促销唯一标识, 用于内部识别促销
     *
     * @return string
     */
    public function uniqueKey();

    /**
     * 促销名称
     *
     * @return string
     */
    public function title();

    /**
     * 促销类型
     *
     * @return string
     */
    public function type();

    /**
     * 价格优惠
     *
     * @param $originalPrice
     *
     * @return float 新价格
     */
    public function pricePromotion($originalPrice);

    /**
     * 积分优惠
     *
     * @param $originalPoint
     *
     * @return int 新积分
     */
    public function pointPromotion($originalPoint);
}