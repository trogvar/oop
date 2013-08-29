<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 29.08.13
 * Time: 15:07
 * To change this template use File | Settings | File Templates.
 */

class XmlProductWriter extends ShopProductWriter
{

    public function WriteAll()
    {
        $str = '<?xml version="1.0" encoiding="UTF-8"?>'."\n";
        $str .= "<products>\n";
        foreach($this->products as $product)
        {
            $str .= "\t<product title=\"{$product->getTitle()}\">\n";
            $str .= "\t\t<summary>\n";
            $str .= "\t\t{$product->getSummaryLine()}\n";
            $str .= "\t\t</summary>\n";
            $str .= "\t</product>\n";
        }
        $str .= "</products>\n";
        print $str;
    }
}