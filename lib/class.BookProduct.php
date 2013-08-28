<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 15:52
 * To change this template use File | Settings | File Templates.
 */

class BookProduct extends ShopProduct
{
    public $numPages = 0;

    function __construct($title, $firstName, $mainName, $price, $numPages)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->$numPages = $numPages;
    }

    function getSummaryLine()
    {
        $base = "{$this->title} ( {$this->producerMainName}, ";
        $base .= "{$this->producerFirstName} )";
        $base .= ": page count - {$this->numPages}";
        return $base;
    }
}