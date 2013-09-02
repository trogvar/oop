<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 30.08.13
 * Time: 17:32
 * To change this template use File | Settings | File Templates.
 */

class ReflectionUtil
{
    static function getClassData(ReflectionClass $class)
    {
        $details = "";
        $name = $class->getName();
        if ($class->isUserDefined())
            $details .= "$name is user defined\n";

        if ($class->isInternal())
            $details .= "$name is buit-in\n";

        if ($class->isInterface())
            $details .= "$name is interface\n";

        if ($class->isAbstract())
            $details .= "$name is abstract\n";

        if ($class->isFinal())
            $details .= "$name is final\n";

        if ($class->isInstantiable())
            $details .= "$name can be instantiated\n";
        else
            $details .= "$name can not be instantiated\n";

        return $details;
    }

    static function getClassSource(ReflectionClass $class)
    {
        $path = $class->getFileName();
        return self::getLinesFromTo($path, $class->getStartLine(), $class->getEndLine());
    }

    static function getMethodSource(ReflectionMethod $method)
    {
        $path = $method->getFileName();
        return self::getLinesFromTo($path, $method->getStartLine(), $method->getEndLine());
    }

    private static function getLinesFromTo($file, $from, $to)
    {
        $lines = @file($file);
        return implode(array_slice($lines, $from - 1, $to - $from + 1));
    }
}