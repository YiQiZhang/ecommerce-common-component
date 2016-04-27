<?php

namespace TechTree\Ecommerce\Cart\Contracts;

interface CartItemDetailContract
{
    /********************************** 修改方法 **************************/
    /**
     * 重新刷新模型
     *
     * @return mixed
     */
    public function renew();

    /********************************** 查询方法 **************************/
    /**
     * 在售状态
     *
     * @return bool
     */
    public function onsale();

    /**
     * 货物id
     *
     * @return int
     */
    public function goodsId();

    /**
     * 目录id
     *
     * @return int
     */
    public function categoryId();

    /**
     * 标题
     *
     * @return string
     */
    public function title();

    /**
     * 封面图
     *
     * @return string
     */
    public function cover();

    /**
     * 原价
     *
     * @return float
     */
    public function originalPrice();

    /**
     * 单价
     *
     * @return float
     */
    public function price();

    /**
     * 积分
     *
     * @return int
     */
    public function point();

    /**
     * 输出基本信息
     *
     * @return array
     */
    public function output();
}
