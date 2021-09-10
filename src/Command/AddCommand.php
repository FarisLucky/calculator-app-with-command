<?php

namespace App\Calculator\Command;

use App\Calculator\Calculator;

class AddCommand extends Calculator
{
    protected function getCommandVerb(): string
    {
        return 'add';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'added';
    }

    protected function getOperator(): string
    {
        return '+';
    }

    /**
     * @param float|int $number1
     * @param float|int $number2
     * @return mixed
     */
    protected function calculate($number1, $number2)
    {
        return $number1 + $number2;
    }
}
