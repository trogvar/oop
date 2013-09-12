<?php
/**
 * Created by JetBrains PhpStorm.
 * User: d.plechystyy
 * Date: 9/11/13
 * Time: 5:41 PM
 * To change this template use File | Settings | File Templates.
 */

abstract class ApptEncoder
{
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Appointment data encode in BloggsCal format\n";
    }
}

class MegaApptEncoder extends ApptEncoder
{
    function encode()
    {
        return "Appointment data encode in MegaCal format\n";
    }
}

abstract class CommsManager
{
    abstract function getHeaderText();
    abstract function getFooterText();
    abstract function getApptEncoder();
}

class BloggsCommsManager extends CommsManager
{

    function getHeaderText()
    {
        return "BloggsCal header\n";
    }

    function getFooterText()
    {
        return "BloggsCal footer\n";
    }

    function getApptEncoder()
    {
        return new BloggsApptEncoder();
    }
}

class MegaCommsManager extends CommsManager
{

    function getHeaderText()
    {
        return "MegaCal header\n";
    }

    function getFooterText()
    {
        return "MegaCal footer\n";
    }

    function getApptEncoder()
    {
        return new MegaApptEncoder();
    }
}

$comms = new MegaCommsManager();
$encoder = $comms->getApptEncoder();
print $encoder->encode();