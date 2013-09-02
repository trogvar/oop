<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 30.08.13
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */

class Product
{
    public $name;
    public $price;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale
{
    private $callbacks;

    function registerCallback($callback)
    {
        if (!is_callable($callback))
            throw new Exception("callback is not callable");

        $this->callbacks[] = $callback;
    }

    function sale($product)
    {
        print "{$product->name}: processing \n";
        foreach ($this->callbacks as $cb)
            call_user_func($cb, $product);
    }
}

class Mailer
{
    function doMail($product)
    {
        print "\tmailing ($product->name)\n";
    }
}

class Totalizer
{
    static function warnAmount($amount)
    {
        return function($product) use ($amount, &$count) {
            $count += $product->price;
            print "\tcount: $count\n";
            if ($count > $amount)
                print "\treached high price: {$count}\n";
        };
    }
}

$logger = function($product) { print "\tlogging ({$product->name})\n"; };
$processor = new ProcessSale();
$processor->registerCallback($logger);
$mailer = new Mailer();
$processor->registerCallback(array($mailer, "doMail"));
$processor->registerCallback(Totalizer::warnAmount(8));

$processor->sale(new Product("shoes", 6));
print "\n";
$processor->sale(new Product("coffee", 5));