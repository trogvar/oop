<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 9/12/13
 * Time: 4:17 PM
 * To change this template use File | Settings | File Templates.
 */

class Sea
{
}

class EarthSea extends Sea
{
}

class MarsSea extends Sea
{
}

class Plains
{
}

class EarthPlains extends Plains
{
}

class MarsPlains extends Plains
{
}

class Forest
{
}

class EarthForest extends Forest
{
}

class MarsForest extends Forest
{
}

class TerrainFactory
{
    private $sea;
    private $forest;
    private $plains;

    function __construct(Sea $sea, Forest $forest, Plains $plains)
    {
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }

    public function getForest()
    {
        return clone($this->forest);
    }

    public function getPlains()
    {
        return clone($this->plains);
    }

    public function getSea()
    {
        return clone($this->sea);
    }

}

$factory = new TerrainFactory(new EarthSea(), new EarthForest(), new EarthPlains());

print_r($factory->getSea());
print_r($factory->getPlains());
print_r($factory->getForest());