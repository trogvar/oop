<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 03.09.13
 * Time: 16:41
 * To change this template use File | Settings | File Templates.
 */

abstract class Lesson
{
    private $duration;
    private $costStrategy;

    function __construct($duration, CostStrategy $costStrategy)
    {
        $this->duration = $duration;
        $this->costStrategy = $costStrategy;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    function cost()
    {
        return $this->costStrategy->cost($this);
    }

    function chargeType()
    {
        return $this->costStrategy->chargeType();
    }
}

abstract class CostStrategy
{
    abstract function cost(Lesson $lesson);

    abstract function chargeType();
}

class FixedCostStrategy extends CostStrategy
{
    function cost(Lesson $lesson)
    {
        return 30;
    }

    function chargeType()
    {
        return "fixed rate";
    }
}

class TimeCostStrategy extends CostStrategy
{
    function cost(Lesson $lesson)
    {
        return $lesson->getDuration() * 5;
    }

    function chargeType()
    {
        return "hourly rate";
    }
}

class Lecture extends Lesson
{

}

class Seminar extends Lesson
{

}


$lessons[] = new Seminar(4, new TimeCostStrategy());
$lessons[] = new Lecture(4, new FixedCostStrategy());

foreach ($lessons as $lesson)
{
    print "lesson charge {$lesson->cost()}. ";
    print "charge type: {$lesson->chargeType()}\n";
}

