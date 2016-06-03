<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use TechTree\Ecommerce\Cart\Interfaces\PromotionCreator;
use TechTree\Ecommerce\Cart\Interfaces\PromotionType;

interface PromotionContract extends PromotionType, PromotionCreator
{
    /**
     * 促销唯一标识, 用于内部识别促销
     *
     * @return string
     */
    public function uniqueKey();

    /**
     * 创建者名称
     *
     * @return string
     */
    public function creator();

    /**
     * 与此促销相关id
     *
     * @return int
     */
    public function relationId();

    /**
     * 与此促销相关的额外数据
     *
     * @return array
     */
    public function externalData();

    /**
     * 促销类型
     *
     * @return string
     */
    public function type();

    /**
     * 价格优惠
     *
     * @param float $originalPrice
     *
     * @return float 新价格
     */
    public function pricePromotion($originalPrice);

    /**
     * 积分优惠
     *
     * @param int $originalPoint
     *
     * @return int 新积分
     */
    public function pointPromotion($originalPoint);

    /**
     * 需要向外传递的一个关键数据
     *
     * @return mixed
     */
    public function promotionData();

    /**
     * 数据格式化
     *
     * @return array
     */
    public function output();
}