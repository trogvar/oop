<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 29.08.13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */

abstract class DomainObject
{
    public static function create()
    {
        return new static();
    }
}

class User extends DomainObject
{

}

class Document extends DomainObject
{

}


$d = Document::create();
var_dump($d);