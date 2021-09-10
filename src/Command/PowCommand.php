<?php

namespace App\Calculator\Command;

use App\Calculator\AritmatikaCommandInterface;
use App\Calculator\Calculator;
use Illuminate\Console\Command;

class PowCommand extends Calculator
{
    public function getCommandVerb(): string
    {
        return 'pow';
    }

    public function getCommandPassiveVerb(): string
    {
        return 'powed';
    }

    public function getOperator(): string
    {
        return '^';
    }

    /**
     * @param float|int $input1
     * @param float|int $input2
     * @return mixed
     */
    public function calculate($input1, $input2)
    {
        return $input1 ** $input2;
    }
}
