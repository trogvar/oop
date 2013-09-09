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
        if (count($this->employees) > 0)
        {
            $emp = array_pop($this->employees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss();
$boss->addEmployee(new Minion("Lina"));
$boss->addEmployee(new CluedUp("James"));
$boss->addEmployee(new Minion("Linda"));

$boss->projectFails();
$boss->projectFails();
$boss->projectFails();