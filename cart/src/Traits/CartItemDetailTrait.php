<?php

namespace TechTree\Ecommerce\Cart\Traits;

trait CartItemDetailTrait
{
    public function output()
    {
        return [
            'goodsId' => $this->goodsId(),
            'categoryId' => $this->categoryId(),
            'title' => $this->title(),
            'cover' => $this->cover(),
            'originalPrice' => $this->originalPrice(),
            'price' => $this->price(),
            'point' => $this->point(),
        ];
    }
}