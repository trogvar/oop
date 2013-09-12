<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 9/11/13
 * Time: 5:08 PM
 * To change this template use File | Settings | File Templates.
 */

class Preferences
{
    private $props = array();
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new Preferences();

        return self::$instance;
    }

    public function setProperty($key, $val)
    {
        $this->props[$key] = $val;
    }

    public function getProperty($key)
    {
        return $this->props[$key];
    }
}

$pref = Preferences::getInstance();
$pref->setProperty("name", "Matt");

unset($pref);

$pref2 = Preferences::getInstance();
echo $pref2->getProperty("name");