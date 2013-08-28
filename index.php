<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

require "./lib/class.ShopProduct.php";
require "./lib/class.ShopProductWriter.php";

$product1 = new ShopProduct("My Antonia", "John", "Carter", 5.99);
$writer = new ShopProductWriter();

$writer->Write($product1);
