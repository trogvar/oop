<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 30.08.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */

class Person
{
    private $name;
    private $id;

    function __construct($name)
    {
        $this->name = $name;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function __destruct()
    {
        if (!empty($this->id))
        {
            print "saving data for person {$this->id}\n";
        }
    }

    function __clone()
    {
        unset($this->id);
    }
}


$p1 = new Person("James McHardy");
$p1->setId(1);

$p2 = new Person("Linna Lindsey");
$p2->setId(2);
$p3 = new Person("Lysa Minally");
$p3->setId(3);

unset($p2);
$p3 = 117;

$p4 = clone $p1;

print_r(get_class_methods('Person'));