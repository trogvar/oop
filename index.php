<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 28.08.13
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

function classLoad($className)
{
    $filename = "./lib/class.$className.php";
    if (file_exists($filename))
        include_once($filename);
}

function interfaceLoad($interfaceName)
{
    $filename = "./lib/interface.$interfaceName.php";
    if (file_exists($filename))
        include_once($filename);
}

spl_autoload_register(array("classLoad", "interfaceLoad"));

$product1 = new BookProduct("My Antonia", "John", "Carter", 5.99, 270);
$xmlWriter = new XmlProductWriter();
$xmlWriter->AddProduct($product1);

$xmlWriter->WriteAll();


$textWriter = new TextProductWriter();
$textWriter->AddProduct($product1);
$textWriter->WriteAll();