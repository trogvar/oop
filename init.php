<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 30.08.13
 * Time: 17:15
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

spl_autoload_register("classLoad");
spl_autoload_register("interfaceLoad");