<?php

namespace TechTree\Ecommerce\Cart\Interfaces;

interface PromotionType
{
    const TYPE_FIXED_PRICE = 'fixed_price';
    const TYPE_PRICE_REDUCTION = 'price_reduction';
    const TYPE_PRICE_DISCOUNT = 'price_discount';
    const TYPE_FIXED_POINT = 'fixed_point';
    const TYPE_EXTRA_POINT= 'extra_point';
}