<?php

namespace TechTree\Ecommerce\Cart\Promotions;

use TechTree\Ecommerce\Cart\Interfaces\AbstractPromotion;

class FixedPrice extends AbstractPromotion
{
    /**
     * @var float
     */
    protected $newPrice;

    /**
     * @param float $newPrice
     */
    public function __construct($newPrice)
    {
        $this->newPrice = $newPrice;
    }

    /**
     * 促销类型
     *
     * @return string
     */
    public function type()
    {
        return self::TYPE_FIXED_PRICE;
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
        return $this->newPrice;
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
        return $this->newPrice;
    }
}
