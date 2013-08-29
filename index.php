<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

require "./lib/class.ShopProduct.php";
require "./lib/class.CdProduct.php";
require "./lib/class.BookProduct.php";
require "./lib/class.ShopProductWriter.php";

$product1 = new BookProduct("My Antonia", "John", "Carter", 5.99, 270);
$writer = new ShopProductWriter();
$writer->AddProduct($product1);

$writer->WriteAll();
