<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 9/12/13
 * Time: 2:23 PM
 * To change this template use File | Settings | File Templates.
 */

abstract class CommsManager
{
    abstract function getHeaderText();

    abstract function getApptEncoder();

    abstract function getTtdEncoder();

    abstract function getContactEncoder();

    abstract function getFooterText();
}

abstract class ApptEncoder
{
    abstract function encode();
}

abstract class ContactEncoder
{
    abstract function encode();
}

abstract class TtdEncoder
{
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Appt encoded in Bloggs format\n";
    }
}

class BloggsTtdEncoder extends TtdEncoder
{
    function encode()
    {
        return "Ttd encoded in Bloggs format\n";
    }

}

class BloggsContactEncoder extends ContactEncoder
{
    function encode()
    {
        return "Contact encoded in Bloggs format\n";
    }

}

class BloggsCommManager extends CommsManager
{
    function getHeaderText()
    {
        return "BloggsCal header\n";
    }

    function getApptEncoder()
    {
        return new BloggsApptEncoder();
    }

    function getTtdEncoder()
    {
        return new BloggsTtdEncoder();
    }

    function getContactEncoder()
    {
        return new BloggsContactEncoder();
    }

    function getFooterText()
    {
        return "BloggsCal footer\n";
    }

}