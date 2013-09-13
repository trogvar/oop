<?php
/**
 * User: d.plechystyy
 * Date: 9/13/13 3:38 PM
 */


// First some ugly messy third-party code

class Product
{
    public $id;
    public $name;

    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

function getProductFileLines($file)
{
    return file($file);
}

function getProductObjectFromId($id, $productname)
{
// some kind of database lookup
    return new Product($id, $productname);
}

function getNameFromLine($line)
{
    if (preg_match("/.*-(.*)\s\d+/", $line, $array)) {
        return str_replace('_', ' ', $array[1]);
    }
    return '';
}

function getIDFromLine($line)
{
    if (preg_match("/^(\d{1,3})-/", $line, $array)) {
        return $array[1];
    }
    return -1;
}

// old, procedural Usage of third-party code
//$lines = getProductFileLines("test.txt");
//$objects = array();
//foreach ($lines as $lines)
//{
//    $id = getIDFromLine($line);
//    $name = getNameFromLine($line);
//    $objects[$id] = getProductObjectFromId($id, $name);
//}


// now implement a facade on top of the procedural code

class ProductFacade
{
    private $products = array();
    private $file;

    function __construct($file)
    {
        $this->file = $file;
        $this->compile();
    }

    private function compile()
    {
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line) {
            $id = getIDFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromId($id, $name);
        }
    }

    function getProducts()
    {
        return $this->products;
    }

    function getProduct($id)
    {
        return $this->products[$id];
    }
}


///usage
//$facade = new ProductFacade("test.txt");
//$facade->getProduct(34);