<?php

namespace TechTree\Ecommerce\Cart\Interfaces;

use TechTree\Ecommerce\Cart\Contracts\PromotionContract;

abstract class AbstractPromotion implements PromotionContract, PromotionType
{
    const UNIQUE_KEY_TEMPLATE = 'cart:promotion:%s';

    /**
     * 促销唯一标识, 用于内部识别促销
     *
     * @return string
     */
    public function uniqueKey()
    {
        return sprintf(self::UNIQUE_KEY_TEMPLATE, $this->type());
    }

    /**
     * 促销名称
     *
     * @return string
     */
    public function title()
    {
        return $this->type();
    }

    public function output()
    {
        return [
            'type'  => $this->type(),
            'title' => $this->title(),
            'data'  => $this->promotionData(),
        ];
    }
}
