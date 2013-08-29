<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 15:52
 * To change this template use File | Settings | File Templates.
 */

class ShopProduct
{
    private  $title = "default product";
    private $producerMainName = "main name";
    private $producerFirstName = "first name";
    protected  $price = 0;
    private $discount = 0;

    function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    function getProducer()
    {
        return "{$this->producerFirstName} {$this->producerMainName}";
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getTitle()
    {
        return $this->title;
    }

    function getPrice()
    {
        return $this->price - $this->discount;
    }

    function getSummaryLine()
    {
        return "$this->title ({$this->producerMainName}, {$this->producerFirstName})";
    }
}