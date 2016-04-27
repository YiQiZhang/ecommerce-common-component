<?php

namespace TechTree\Ecommerce\Cart\Promotions;

use TechTree\Ecommerce\Cart\Interfaces\AbstractPromotion;

class PriceDiscount extends AbstractPromotion
{
    /**
     * @var float
     */
    protected $discount;

    /**
     * @param float $discount(0~1)
     */
    public function __construct($discount)
    {
        $this->discount = $discount;
    }

    /**
     * 促销类型
     *
     * @return string
     */
    public function type()
    {
        return self::TYPE_PRICE_DISCOUNT;
    }

    /**
     * 价格优惠
     *
     * @param float $originalPrice
     *
     * @return float 新价格
     */
    public function pricePromotion($originalPrice)
    {
        return $originalPrice * $this->discount;
    }

    /**
     * 积分优惠
     *
     * @param int $originalPoint
     *
     * @return int 新积分
     */
    public function pointPromotion($originalPoint)
    {
        return $originalPoint;
    }

    /**
     * 需要向外传递的数据
     *
     * @return mixed
     */
    public function promotionData()
    {
        return $this->discount;
    }
}
