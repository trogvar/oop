<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 30.08.13
 * Time: 14:27
 * To change this template use File | Settings | File Templates.
 */

namespace theirs
{
    class Debug
    {
        public static function foo()
        {
            echo "Inside Debug::foo() (".__NAMESPACE__.")";
        }
    }
}

namespace my
{
    use \theirs\Debug as alias;

    class Debug
    {
        public static function foo()
        {
            echo "Inside Debug::foo() (".__NAMESPACE__.")";
        }
    }

    alias::foo();
    Debug::foo();
}