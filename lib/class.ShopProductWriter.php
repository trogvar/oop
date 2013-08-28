<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 17:24
 * To change this template use File | Settings | File Templates.
 */

class ShopProductWriter
{
    public function Write(ShopProduct $product)
    {
        $str = "{$product->title}: {$product->getProducer()} ({$product->price})\n";
        print $str;
    }
}