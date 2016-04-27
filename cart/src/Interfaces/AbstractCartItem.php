<?php

namespace TechTree\Ecommerce\Cart\Interfaces;

use Illuminate\Support\Collection;
use TechTree\Ecommerce\Cart\Contracts\CartItemContract;
use TechTree\Ecommerce\Cart\Contracts\PromotionContract;

abstract class AbstractCartItem implements CartItemContract, CartItemType
{
    /**
     * @var int 商品项数量
     */
    protected $quantity;

    /**
     * @var bool 是否选中
     */
    protected $isSelected;

    /**
     * @var bool 是否原始的购物车商品
     */
    protected $isOriginal;

    /**
     * @var Collection 内含PromotionContract
     */
    protected $promotions;

    public function __construct($quantity = 1, $isSelected = true, $isOriginal = true)
    {
        $this->quantity = $quantity;
        $this->isSelected = $isSelected;
        $this->isOriginal = $isOriginal;
        $this->promotions = new Collection();
    }

    /********************************** 修改方法 **************************/
    /**
     * 增加一个促销项
     *
     * @param PromotionContract $prmotion
     *
     * @return bool
     */
    public function addPromotion(PromotionContract $prmotion)
    {
        $this->promotions->put($prmotion->uniqueKey(), $prmotion);

        return true;
    }

    /**
     * 移除一个促销项
     *
     * @param $promotionUniqueKey
     *
     * @return mixed
     */
    public function removePromotion($promotionUniqueKey)
    {
        $this->promotions->forget($promotionUniqueKey);

        return true;
    }

    /**
     * 清除所有促销项
     *
     * @return bool
     */
    public function clearPromotions()
    {
        $this->promotions = new Collection();
    }

    /**
     * 更新购物车项数量
     *
     * @param int $quantity
     *
     * @return bool
     */
    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * 更新购物车项选中状态
     *
     * @param bool $status
     *
     * @return bool
     */
    public function select($status)
    {
        $this->isSelected = $status;
    }

    /********************************** 查询方法 **************************/
    /**
     * 可接受的促销类型
     *
     * @return string[]
     */
    public function acceptPromotions()
    {
        return [
            PromotionType::TYPE_EXTRA_POINT,
            PromotionType::TYPE_FIXED_POINT,
            PromotionType::TYPE_FIXED_PRICE,
            PromotionType::TYPE_PRICE_DISCOUNT,
            PromotionType::TYPE_PRICE_REDUCTION,
        ];
    }

    /**
     * 选中状态
     *
     * @return bool
     */
    public function isSelected()
    {
        return $this->isSelected;
    }

    /**
     * 是否购物车中原始的商品, 还是经过filter之后生成的商品
     *
     * @return bool
     */
    public function isOriginal()
    {
        return $this->isOriginal;
    }

    /**
     * 该购物车项数量
     *
     * @return int
     */
    public function quantity()
    {
        return $this->quantity;
    }

    /**
     * @return array
     */
    public function output()
    {
        $return = [
            'id' => $this->uniqueKey(),
            'title' => $this->title(),
            'type' => $this->type(),
            'is_multiple' => $this->isMultiple(),
            'select' => $this->isSelected(),
            'price' => $this->price(),
            'quantity' => $this->quantity(),
            'promotions' => []
        ];
        /** @var PromotionContract $promotion */
        foreach($this->promotions as $promotion){
            $return['promotions'][] = $promotion->output();
        }

        return $return;
    }
}