<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 9/9/13
 * Time: 4:19 PM
 * To change this template use File | Settings | File Templates.
 */

abstract class Employee
{
    protected $name;

    private static $types = array('minion', 'cluedup', 'wellconnected');

    static function recruit($name)
    {
        $num = rand(1, count(self::$types))-1;
        $class = self::$types[$num];
        return new $class($name);
    }

    function __construct($name)
    {
        $this->name = $name;
    }

    abstract function fire();
}

class Minion extends Employee
{
    function fire()
    {
        print "{$this->name}: I'll clear my desk *SIGH*\n";
    }
}

class WellConnected extends Employee
{
    function fire()
    {
        print "{$this->name}: I'll call my dad\n";
    }
}

class CluedUp extends Employee
{
    function fire()
    {
        print "{$this->name}: I'll call my lawyer\n";
    }
}

class NastyBoss
{
    private $employees = array();

    function addEmployee(Employee $employee)
    {
        $this->employees[] = $employee;
    }

    function projectFails()
    {
        if (count($this->employees) > 0) {
            $emp = array_pop($this->employees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss();
$boss->addEmployee(Employee::recruit("Lina"));
$boss->addEmployee(Employee::recruit("James"));
$boss->addEmployee(Employee::recruit("Linda"));

$boss->projectFails();
$boss->projectFails();
$boss->projectFails();