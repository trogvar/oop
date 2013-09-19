<?php
/**
 * User: d.plechystyy
 * Date: 9/19/13 10:33 AM
 */


//$a = array(1, 2, 3, 5);
//
//$b = array(1);
//
//print_r(array_udiff($a, $b, function ($value1, $value2) { if ($value1 < $value2) return -1; else if ($value1 == $value2) return 0; else return 1;}));
//
//$incer = function(& $elt) { $elt++; };
//array_walk($a, $incer);
//print_r($a);

class SomeClass
{
    private $collection = array();

    function __construct(Array $collection)
    {
        $this->collection = $collection;
    }

    function dooFooStuff($increment)
    {
        $incFunc = function (& $elt) use ($increment) {
            $elt += $increment;
        };
        array_walk($this->collection, $incFunc);
        print_r($this->collection);
    }
}

$sc = new SomeClass(array(1, 2, 3));
//$sc->dooFooStuff(2);

interface IObserver
{
    function update(IObservable $source);
}

class FileLogger implements IObserver
{
    function update(IObservable $source)
    {
        echo "FileLogger::update() called to log to file instance of: " . $source->getData() . "\n";
    }

}

class XmlLogger implements IObserver
{
    function update(IObservable $source)
    {
        echo "XmlLogger::update() called to log to file instance of: <xml><data>" . $source->getData() . "</data>\n";
    }

}

interface IObservable
{
    function attach(IObserver $observer);

    function detach(IObserver $observer);

    function notify();
}

class MyObservableClass implements IObservable
{
    private $observers;
    private $data;

    public function setData($data)
    {
        $this->data = $data;
        $this->notify();
    }

    public function getData()
    {
        return $this->data;
    }

    function attach(IObserver $observer)
    {
        $this->observers[] = $observer;
    }

    function detach(IObserver $observer)
    {
        $this->observers = array_udiff($this->observers, array($observer), function ($o1, $o2) {
            return $o1 === $o2 ? 0 : 1;
        });
    }

    function notify()
    {
        $t = $this;
        $myNotifier = function (IObserver $observer) use ($t) {
            $observer->update($t);
        };
        array_walk($this->observers, $myNotifier);
    }

}

$moc = new MyObservableClass();
$moc2 = new MyObservableClass();

$fileLogger = new FileLogger();
$xmlLogger = new XmlLogger();

$moc->attach($fileLogger);
$moc->attach($xmlLogger);
$moc2->attach($xmlLogger);

$moc->setData("blablabla");
$moc2->setData(101723);