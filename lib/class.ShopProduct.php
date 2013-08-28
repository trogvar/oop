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
    public $title = "default product";
    public $producerMainName = "main name";
    public $producerFirstName = "first name";
    public $price = 0;

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

    function getSummaryLine()
    {
        return "$this->title ({$this->producerMainName}, {$this->producerFirstName})";
    }
}