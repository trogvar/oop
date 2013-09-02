<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 30.08.13
 * Time: 17:13
 * To change this template use File | Settings | File Templates.
 */

require_once "init.php";

$prod_class = new ReflectionClass("CdProduct");
//Reflection::export($prod_class);

//print(ReflectionUtil::getClassData($prod_class));
//print(ReflectionUtil::getClassSource($prod_class));

$method = $prod_class->getMethod('getSummaryLine');
print ReflectionUtil::getMethodSource($method);