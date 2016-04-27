<?php

namespace TechTree\Ecommerce\Cart\Models\CartItem;

use Illuminate\Support\Collection;
use TechTree\Ecommerce\Cart\Contracts\CartItemContract;
use TechTree\Ecommerce\Cart\Contracts\PromotionContract;
use TechTree\Ecommerce\Cart\Interfaces\AbstractCartItem;

class MultiItem extends AbstractCartItem
{
    const UNIQUE_KEY_TEMPLATE = 'cart:multi-item:%s';

    /**
     * @var CartItemContract[]
     */
    protected $details;

    /**
     * @var string
     */
    protected $uniqueKey;

    /**
     * @param CartItemContract[] $details
     * @param int                $quantity
     * @param bool|true          $isSeletced
     * @param bool|true          $isOriginal
     */
    public function __construct(
        $details,
        $quantity = 1,
        $isSeletced = true,
        $isOriginal = true
    ) {
        parent::__construct($quantity, $isSeletced, $isOriginal);
        $this->details = new Collection($details);
        $this->uniqueKey = $this->buildUniqueKey();
    }

    /**
     * 重新刷新模型
     */
    public function renew()
    {
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $detail->renew();
        }
    }

    /**
     * 构建唯一标识
     *
     * @return string
     */
    protected function buildUniqueKey()
    {
        $goodsIds = [];
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $goodsIds = array_merge($goodsIds, $detail->goodsIds());
        }
        array_unique($goodsIds);
        sort($goodsIds);

        return md5(sprintf(self::UNIQUE_KEY_TEMPLATE, implode(',', $goodsIds)));
    }

    /**
     * 唯一标识
     *
     * @return string
     */
    public function uniqueKey()
    {
        return $this->uniqueKey;
    }

    /**
     * 标题
     *
     * @return string
     */
    public function title()
    {
        $title = '';
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $k => $detail) {
            if ($k > 0) {
                $title .= ',' . $detail->title();
            } else {
                $title .= $detail->title();
            }
        }

        return $title;
    }

    /**
     * 封面图
     *
     * @return string
     */
    public function cover()
    {
        $cover = '';
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $cover = $detail->cover();
            if (!empty($cover)) {
                break;
            }
        }

        return $cover;
    }

    /**
     * 类型
     *
     * @return string
     */
    public function type()
    {
        return self::TYPE_MULTI_ITEM;
    }

    /**
     * 此购物车项是否还在生效
     *
     * @return bool
     */
    public function onsale()
    {
        $onsale = true;
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            if (!$detail->onsale()) {
                $onsale = false;
                break;
            }
        }

        return $onsale;
    }

    /**
     * 是否有多个实体在此项中
     *
     * @return bool
     */
    final public function isMultiple()
    {
        return true;
    }

    /**
     * 单位该购物车项的商品数量
     *
     * @return int
     */
    public function goodsCount()
    {
        $goodsCount = 0;
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $goodsCount += $detail->goodsCount();
        }

        return $goodsCount;
    }

    /**
     * 该购物车项包含的所有商品的id
     *
     * @return array
     */
    public function goodsIds()
    {
        $goodsIds = [];
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $goodsIds = array_merge($goodsIds, $detail->goodsIds());
        }

        return array_unique($goodsIds);
    }

    /**
     * 该购物车项包含的所有商品的目录id
     *
     * @return array
     */
    public function categoryIds()
    {
        $categoryIds = [];
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $categoryIds = array_merge($categoryIds, $detail->categoryIds());
        }

        return array_unique($categoryIds);
    }

    /**
     * 原价
     *
     * @return float
     */
    public function originalPrice()
    {
        $originalPrice = 0.00;
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $originalPrice += $detail->originalPrice() * $detail->quantity();
        }

        return $originalPrice;
    }

    /**
     * 应用所有促销规则后的现价
     *
     * @return float
     */
    public function price()
    {
        $price = 0.00;
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $price += $detail->price() * $detail->quantity();
        }

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
        $point = 0;
        /** @var CartItemContract $detail */
        foreach ($this->detail() as $detail) {
            $point += $detail->point() * $detail->quantity();
        }

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
        $return['detail'] = [];
        foreach($this->detail() as $detail) {
            $return['detail'][] = $detail->output();
        }
    }

    /**
     * 购物车项的明细
     *
     * @return CartItemContract[]
     */
    public function detail()
    {
        return $this->details;
    }
}
