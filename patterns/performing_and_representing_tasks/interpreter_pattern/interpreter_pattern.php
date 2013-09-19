<?php
/**
 * User: d.plechystyy
 * Date: 9/16/13 2:54 PM
 */

abstract class Expression
{
    private static $keyCount = 0;
    private $key;

    abstract function interpret(InterpreterContext $context);

    function getKey()
    {
        if (!isset($this->key)) {
            self::$keyCount++;
            $this->key = self::$keyCount;
        }

        return $this->key;
    }
}

class LiteralExpression extends Expression
{
    private $value;

    function __construct($value)
    {
        $this->value = $value;
    }

    function interpret(InterpreterContext $context)
    {
        $context->replace($this, $this->value);
    }
}

class InterpreterContext
{
    private $expressionStore = array();

    function replace(Expression $exp, $value)
    {
        $this->expressionStore[$exp->getKey()] = $value;
    }

    function lookup(Expression $exp)
    {
        return $this->expressionStore[$exp->getKey()];
    }
}

class VariableExpression extends Expression
{
    private $name;
    private $value;

    function __construct($name, $val = null)
    {
        $this->name = $name;
        $this->value = $val;
    }

    function interpret(InterpreterContext $context)
    {
        if (!is_null($this->value)) {
            $context->replace($this, $this->value);
            $this->value = null;
        }
    }

    function setValue($value)
    {
        $this->value = $value;
    }

    function getKey()
    {
        return $this->name;
    }
}

abstract class OperatorExpression extends Expression
{
    protected $leftOperand;
    protected $rightOperand;

    function __construct(Expression $left, Expression $right)
    {
        $this->leftOperand = $left;
        $this->rightOperand = $right;
    }

    function interpret(InterpreterContext $context)
    {
        $this->leftOperand->interpret($context);
        $this->rightOperand->interpret($context);
        $resultLeft = $context->lookup($this->leftOperand);
        $resultRight = $context->lookup($this->rightOperand);
        $this->doInterpret($context, $resultLeft, $resultRight);
    }

    protected abstract function doInterpret(InterpreterContext $context, $resultLeft, $resultRight);

}

class EqualsExpression extends OperatorExpression
{
    protected function doInterpret(InterpreterContext $context, $resultLeft, $resultRight)
    {
        $context->replace($this, $resultRight === $resultLeft);
    }
}

class BooleanOrExpression extends OperatorExpression
{
    protected function doInterpret(InterpreterContext $context, $resultLeft, $resultRight)
    {
        $context->replace($this, $resultLeft || $resultRight);
    }
}

class BooleanAndExpression extends OperatorExpression
{
    protected function doInterpret(InterpreterContext $context, $resultLeft, $resultRight)
    {
        $context->replace($this, $resultLeft && $resultRight);
    }
}

// Some separate tests
//
//$context = new InterpreterContext();
//$literal = new LiteralExpression('four');
//$literal->interpret($context);
//
//$myVar = new VariableExpression('input', 'five');
//$myVar->interpret($context);
//
//print $context->lookup($literal) . "\n";
//print $context->lookup($myVar) . "\n";
//
//$newVar = new VariableExpression('input');
//$newVar->interpret($context);
//print $context->lookup($newVar) . "\n";
//
//$myVar->setValue('six');
//$myVar->interpret($context);
//print $context->lookup($myVar) . "\n";
//print $context->lookup($newVar) . "\n";

//Test the minilanguage interpretation
// $input equals "4" or $input equals "four"
$ctx = new InterpreterContext();
$input = new VariableExpression("input");
$statement = new BooleanOrExpression(
    new EqualsExpression($input, new LiteralExpression("4")),
    new EqualsExpression($input, new LiteralExpression("four"))
);

$values = array(52, "four", "4", 4, "44");

foreach ($values as $val) {
    $input->setValue($val);
    $statement->interpret($ctx);

    print "Evaluating with value " . $ctx->lookup($input) . "(" . gettype($ctx->lookup($input)) . "): ";
    print $ctx->lookup($statement) ? "true" : "false";
    print "\n";
}

