<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 29.08.13
 * Time: 13:52
 * To change this template use File | Settings | File Templates.
 */

class StaticExample
{
    static public $aNum = 0;

    static public function sayHello()
    {
        self::$aNum++;
        print "hello (".self::$aNum.")\n";
    }
}

/*StaticExample::sayHello();
StaticExample::sayHello();*/



