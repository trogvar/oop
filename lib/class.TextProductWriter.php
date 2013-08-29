<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 29.08.13
 * Time: 15:07
 * To change this template use File | Settings | File Templates.
 */

class TextProductWriter extends ShopProductWriter
{

    public function WriteAll()
    {
        $str = "Products: \n";
        foreach($this->products as $product)
        {
            $str .= "{$product->getSummaryLine()}\n";
        }
        print $str;
    }
}