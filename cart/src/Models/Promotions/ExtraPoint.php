<?php

namespace TechTree\Ecommerce\Cart\Promotions;

use TechTree\Ecommerce\Cart\Interfaces\AbstractPromotion;

class ExtraPoint extends AbstractPromotion
{
    /**
     * @var int
     */
    protected $extraPoint;

    /**
     * @param int $extraPoint
     */
    public function __construct($extraPoint)
    {
        $this->extraPoint = $extraPoint;
    }

    /**
     * 促销类型
     *
     * @return string
     */
    public function type()
    {
        return self::TYPE_EXTRA_POINT;
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
        return $originalPrice;
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
        return $originalPoint + $this->extraPoint;
    }

    /**
     * 需要向外传递的数据
     *
     * @return mixed
     */
    public function promotionData()
    {
        return $this->extraPoint;
    }
}
