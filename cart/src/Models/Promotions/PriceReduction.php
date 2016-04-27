<?php

namespace TechTree\Ecommerce\Cart\Promotions;

use TechTree\Ecommerce\Cart\Interfaces\AbstractPromotion;

class PriceReduction extends AbstractPromotion
{
    /**
     * @var float
     */
    protected $reduction;

    /**
     * @param float $reduction
     */
    public function __construct($reduction)
    {
        $this->reduction = $reduction;
    }

    /**
     * 促销类型
     *
     * @return string
     */
    public function type()
    {
        return self::TYPE_PRICE_REDUCTION;
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
        if ($originalPrice >= $this->reduction) {
            return $originalPrice - $this->reduction;
        } else {
            return 0.00;
        }
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
        return $this->reduction;
    }
}
