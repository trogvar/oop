<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 15:52
 * To change this template use File | Settings | File Templates.
 */

class ShopProduct implements IChargeable
{
    private $id = 0;
    private $title = "default product";
    private $producerMainName = "main name";
    private $producerFirstName = "first name";
    protected $price = 0;
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

    public function setId($id)
    {
        $this->id = $id;
    }

    function getSummaryLine()
    {
        return "$this->title ({$this->producerMainName}, {$this->producerFirstName})";
    }

    public static function getInstance($id, PDO $pdo)
    {
        $query = $pdo->prepare("select * from products where id=?");
        $result = $query->execute(array($id));

        $row = $query->fetch();
        if(empty($row))
            return null;

        $product = new ShopProduct($row["title"], "", "", $row["price"]);
        $product->setId($row["id"]);
        return $product;
    }
}