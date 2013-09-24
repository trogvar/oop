<?php
/**
 * User: d.plechystyy
 * Date: 9/23/13 12:08 PM
 */

abstract class Unit
{
    function getComposite()
    {
        return null;
    }

    abstract function bombardStrength();

    protected $depth = 0;

    function accept(ArmyVisitor $visitor)
    {
        $method = "visit" . get_class($this);
        $visitor->$method($this);
    }

    protected function setDepth($depth)
    {
        $this->depth = $depth;
    }

    public function getDepth()
    {
        return $this->depth;
    }
}

abstract class CompositeUnit extends Unit
{
    private $units = array();

    function getComposite()
    {
        return $this;
    }

    function setDepth($depth)
    {
        parent::setDepth($depth);
        foreach ($this->units as $unit)
            $unit->setDepth($unit->getDepth() + 1);
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

        $unit->setDepth($this->depth + 1);
        $this->units[] = $unit;
    }

    function accept(ArmyVisitor $visitor)
    {
        $method = "visit" . get_class($this);
        $visitor->$method($this);
        foreach ($this->units as $thisunit) {
            $thisunit->accept($visitor);
        }
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

abstract class ArmyVisitor
{
    abstract function visit(Unit $node);

    function visitArcher(Archer $node)
    {
        $this->visit($node);
    }

    function visitLaserCannon(LaserCannon $node)
    {
        $this->visit($node);
    }

    function visitTroopCarrier(TroopCarrier $node)
    {
        $this->visit($node);
    }

    function visitArmy(Army $node)
    {
        $this->visit($node);
    }
}

class TextDumpArmyVisitor extends ArmyVisitor
{
    private $text = "";

    function visit(Unit $node)
    {
        $ret = "";
        $pad = 4 * $node->getDepth();
        $ret .= sprintf("%{$pad}s", "");
        $ret .= get_class($node) . ": ";
        $ret .= "bombard: " . $node->bombardStrength() . "\n";
        $this->text .= $ret;
    }

    function getText()
    {
        return $this->text;
    }
}

class TaxCollectionVisitor extends ArmyVisitor
{
    private $due = 0;
    private $report = "";

    function visit(Unit $node)
    {
        $this->levy($node, 1);
    }

    function visitArcher(Archer $node)
    {
        $this->levy($node, 2);
    }

    function visitLasercannon(LaserCannon $node)
    {
        $this->levy($node, 3);
    }

    function visitTroopCarrier(TroopCarrier $node)
    {
        $this->levy($node, 5);
    }

    private function levy(Unit $unit, $amount)
    {
        $this->report .= "Tax levied for " . get_class($unit);
        $this->report .= ": $amount \n";
        $this->due += $amount;
    }

    function getReport()
    {
        return $this->report;
    }

    function getTax()
    {
        return $this->due;
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

$textdump = new TextDumpArmyVisitor();
$mainArmy->accept($textdump);
print $textdump->getText();

$taxcollector = new TaxCollectionVisitor();
$mainArmy->accept($taxcollector);
echo $taxcollector->getReport();
echo $taxcollector->getTax();