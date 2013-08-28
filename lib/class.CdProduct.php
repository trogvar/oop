<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 15:52
 * To change this template use File | Settings | File Templates.
 */

class CdProduct extends ShopProduct
{
    public $playLength = 0;

    function __construct($title, $firstName, $mainName, $price, $playLength)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->playLength = $playLength;
    }

    function getSummaryLine()
    {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        $base .= ": playing time - {$this->playLength}";
        return $base;
    }
}