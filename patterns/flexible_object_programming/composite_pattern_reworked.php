<?php
/**
 * User: d.plechystyy
 * Date: 9/13/13 1:15 PM
 */

abstract class Unit
{
    function getComposite()
    {
        return null;
    }

    abstract function bombardStrength();
}

abstract class CompositeUnit extends Unit
{
    private $units = array();

    function getComposite()
    {
        return $this;
    }

    protected function units()
    {
        return $this->units;
    }

    function removeUnit(Unit $unit)
    {
        $this->units = array_udiff($this->units, array($unit), function ($a, $b) {
            return ($a === $b) ? 0 : 1;
        });
    }

    function addUnit(Unit $unit)
    {
        if (in_array($unit, $this->units, true))
            return;

        $this->units[] = $unit;
        //print "Added a unit: ".get_class($unit).". New count: ".count($this->units)."\n";
    }
}

class Archer extends Unit
{
    function bombardStrength()
    {
        return 4;
    }

}

class LaserCannon extends Unit
{
    function bombardStrength()
    {
        return 44;
    }
}

class Army extends CompositeUnit
{
    function bombardStrength()
    {
        $ret = 0;
        $units = $this->units();
        foreach ($units as $unit) {
            $ret += $unit->bombardStrength();
        }

        return $ret;

    }
}

class TroopCarrier extends CompositeUnit
{
    function addUnit(Unit $unit)
    {
        if (count($this->units()) >= 10)
            return;

        parent::addUnit($unit);
    }

    function bombardStrength()
    {
        $ret = 0;
        $units = $this->units();
        foreach ($units as $unit) {
            $ret += $unit->bombardStrength();
        }

        return $ret;
    }
}

$mainArmy = new Army();
$mainArmy->addUnit(new Archer()); //4
$mainArmy->addUnit(new LaserCannon()); //44

$subArmy = new Army();
$subArmy->addUnit(new Archer()); //4
$subArmy->addUnit(new Archer()); //4
$subArmy->addUnit(new Archer()); //4


for ($i = 0, $carrier = new TroopCarrier(); $i < 13; $i++) {
    $carrier->addUnit(new Archer()); //4 x 10
}

$mainArmy->addUnit($subArmy);
$mainArmy->addUnit($carrier);

print "attacking with strength: {$mainArmy->bombardStrength()}\n";

class UnitScript
{
    static function joinExisting(Unit $newUnit, Unit $occupyingUnit)
    {
        $comp = null;

        if (is_null($comp = $occupyingUnit->getComposite())) {
            $comp = new Army();
            $comp->addUnit($occupyingUnit);
            $comp->addUnit($newUnit);
        } else
            $comp->addUnit($newUnit);

        return $comp;
    }
}