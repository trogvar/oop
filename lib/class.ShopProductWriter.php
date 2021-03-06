<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 17:24
 * To change this template use File | Settings | File Templates.
 */

abstract class ShopProductWriter
{
    protected  $products;

    function __construct()
    {
        $this->products = array();
    }

    public function WriteSingle(ShopProduct $product)
    {
        $str = "{$product->getTitle()}: {$product->getProducer()} ({$product->getPrice()})\n";
        print $str;
    }

    public function AddProduct(ShopProduct $product)
    {
        $this->products[] = $product;
    }

    public abstract function WriteAll();
}