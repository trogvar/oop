<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

require_once "init.php";

$product1 = new BookProduct("My Antonia", "John", "Carter", 5.99, 270);
$xmlWriter = new XmlProductWriter();
$xmlWriter->AddProduct($product1);

$xmlWriter->WriteAll();


$textWriter = new TextProductWriter();
$textWriter->AddProduct($product1);
$textWriter->WriteAll();