<?php
/**
 * User: d.plechystyy
 * Date: 9/18/13 5:00 PM
 */
abstract class Question
{
    protected $prompt;
    protected $marker;

    function __construct($prompt, Marker $marker)
    {
        $this->prompt = $prompt;
        $this->marker = $marker;
    }

    function mark($response)
    {
        return $this->marker->mark($response);
    }
}

class TextQuestion extends Question
{
    // do text question specific things
}

class AVQuestion extends Question
{
    //do audio-visual question specific things
}

abstract class Marker
{
    protected $test;

    function __construct($test)
    {
        $this->test = $test;
    }

    abstract function mark($response);
}

class MatchMarker extends Marker
{
    function mark($response)
    {
        return ($this->test == $response);
    }
}

class RegexpMarker extends Marker
{
    function mark($response)
    {
        return preg_match($this->test, $response);
    }

}

