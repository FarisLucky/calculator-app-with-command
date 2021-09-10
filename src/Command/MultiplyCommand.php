<?php


namespace App\Calculator\Command;


use App\Calculator\Calculator;

class MultiplyCommand extends Calculator
{

    protected function getCommandVerb(): string
    {
        return 'multiply';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'multiplied';
    }

    protected function getOperator(): string
    {
        return '*';
    }

    /**
     * @param float|int $number1
     * @param float|int $number2
     * @return float|int
     */
    protected function calculate($number1, $number2)
    {
        return $number1 * $number2;
    }
}