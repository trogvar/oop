<?php
/**
 * User: d.plechystyy
 * Date: 9/26/13 4:03 PM
 */

namespace woo\command;

class CommandResolver
{
    private static $baseCmdClass;
    private static $defaultCmd;

    function __construct()
    {
        if (!self::$baseCmdClass) {
            self::$baseCmdClass = new \ReflectionClass("\\woo\\command\\Command");
            self::$defaultCmd = new Defaultcommand();
        }
    }

    function getCommand(\woo\controller\Request $request)
    {
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;

        if (!$cmd)
            return self::$defaultCmd;

        $cmd = str_replace(array('.', $sep), "", $cmd);
        $filepath = "command{$sep}{$cmd}.php";
        $classname = "woo\\command\\{$cmd}";
        if (file_exists($filepath)) {
            require_once("$filepath");
            if (class_exists($classname)) {
                $cmdClass = new \ReflectionClass($classname);
                if ($cmdClass->isSubclassOf(self::$baseCmdClass)) {
                    return $cmdClass->newInstance();
                } else {
                    $request->addFeedback("commanda '$cmd' is not a Command");
                }
            }
        }

        $request->addFeedback("command '$cmd' not found (a file)");
        return clone self::$defaultCmd;
    }
}