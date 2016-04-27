<?php

namespace TechTree\Ecommerce\Cart\Models\CartItem;

use TechTree\Ecommerce\Cart\Contracts\CartItemDetailContract;
use TechTree\Ecommerce\Cart\Contracts\PromotionContract;
use TechTree\Ecommerce\Cart\Interfaces\AbstractCartItem;

class SingleItem extends AbstractCartItem
{
    const UNIQUE_KEY_TEMPLATE = 'cart:single-item:%s';

    /**
     * @var CartItemDetailContract
     */
    protected $detail;

    /**
     * @var bool
     */
    protected $isOriginal;

    public function __construct(
        CartItemDetailContract $detail,
        $quantity = 1,
        $isSeletced = true,
        $isOriginal = true
    ) {
        parent::__construct($quantity, $isSeletced, $isOriginal);
        $this->detail = $detail;
    }

    /**
     * 重新刷新模型
     */
    public function renew()
    {
        $this->detail()->renew();
    }

    /**
     * 唯一标识
     *
     * @return string
     */
    public function uniqueKey()
    {
        return md5(sprintf(self::UNIQUE_KEY_TEMPLATE, $this->detail()->goodsId()));
    }

    /**
     * 标题
     *
     * @return string
     */
    public function title()
    {
        return $this->detail()->title();
    }

    /**
     * 封面图
     *
     * @return string
     */
    public function cover()
    {
        return $this->detail()->cover();
    }

    /**
     * 类型
     *
     * @return string
     */
    public function type()
    {
        return self::TYPE_SINGLE_ITEM;
    }

    /**
     * 此购物车项是否还在生效
     *
     * @return bool
     */
    public function onsale()
    {
        return $this->detail()->onsale();
    }

    /**
     * 是否有多个实体在此项中
     *
     * @return bool
     */
    final public function isMultiple()
    {
        return false;
    }

    /**
     * 单位该购物车项的商品数量
     *
     * @return int
     */
    public function goodsCount()
    {
        return $this->detail()->quantity();
    }

    /**
     * 该购物车项包含的所有商品的id
     *
     * @return array
     */
    public function goodsIds()
    {
        return [$this->detail()->goodsId()];
    }

    /**
     * 该购物车项包含的所有商品的目录id
     *
     * @return array
     */
    public function categoryIds()
    {
        return [$this->detail()->categoryId()];
    }

    /**
     * 原价
     *
     * @return float
     */
    public function originalPrice()
    {
        return $this->detail()->originalPrice();
    }

    /**
     * 应用所有促销规则后的现价
     *
     * @return float
     */
    public function price()
    {
        $price = $this->detail()->price();
        /** @var PromotionContract $promotion */
        foreach ($this->promotions as $promotion) {
            $price = $promotion->pricePromotion($price);
        }

        return $price;
    }

    /**
     * 应用所有促销规则后的送积分数
     *
     * @return int
     */
    public function point()
    {
        $point = $this->detail()->point();
        /** @var PromotionContract $promotion */
        foreach ($this->promotions as $promotion) {
            $point = $promotion->pointPromotion($point);
        }

        return $point;
    }

    /**
     * @return array
     */
    public function output()
    {
        $return = parent::output();
        $return['detail'] = $this->detail()->output();
    }

    /**
     * 购物车项的明细
     *
     * @return CartItemDetailContract
     */
    public function detail()
    {
        return $this->detail;
    }
}
