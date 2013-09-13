<?php
/**
 * User: d.plechystyy
 * Date: 9/13/13 3:03 PM
 */

abstract class Tile
{
    abstract function getWealthFactor();
}

class Plains extends Tile
{
    private $wealthFactor = 2;

    function getWealthFactor()
    {
        return $this->wealthFactor;
    }
}

abstract class TileDecorator extends Tile
{
    protected $tile;

    function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator
{
    function getWealthFactor()
    {
        return $this->tile->getWealthFactor() + 2;
    }
}

class PollutedDecorator extends TileDecorator
{
    function getWealthFactor()
    {
        return $this->tile->getWealthFactor() - 4;
    }
}

$tile = new Plains();
print $tile->getWealthFactor();

$tile = new DiamondDecorator(new Plains());
print $tile->getWealthFactor();

$tile = new PollutedDecorator(new DiamondDecorator(new Plains()));
print $tile->getWealthFactor();