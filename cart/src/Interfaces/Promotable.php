<?php

namespace TechTree\Ecommerce\Cart\Interfaces;

use TechTree\Ecommerce\Cart\Contracts\PromotionContract;

interface Promotable
{
    /**
     * 增加一个促销项
     *
     * @param PromotionContract $prmotion
     *
     * @return bool
     */
    public function addPromotion(PromotionContract $prmotion);

    /**
     * 移除一个促销项
     *
     * @param $promotionUniqueKey
     *
     * @return mixed
     */
    public function removePromotion($promotionUniqueKey);

    /**
     * 清除所有促销项
     *
     * @return bool
     */
    public function clearPromotions();

    /**
     * 可接受的促销类型
     *
     * @return string[]
     */
    public function acceptPromotions();
}