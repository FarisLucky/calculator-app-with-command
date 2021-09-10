<?php

namespace App\Calculator;

use Illuminate\Console\Command;

abstract class Calculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );
        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));
        parent::__construct();
    }

    protected abstract function getCommandVerb(): string;

    protected abstract function getCommandPassiveVerb(): string;

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);

        $this->comment(
            sprintf('%s = %s', $description, number_format($result, 0, ',', '.'))
        );
        $this->recordHistory(
            ucwords($this->getCommandPassiveVerb()),
            $description,
            $result,
            sprintf('%s = %s', $description, $result)
        );
    }

    public function getInput(): array
    {
        return $this->argument('numbers');
    }

    public function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected abstract function getOperator(): string;

    protected abstract function calculate($number1, $number2);

    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    protected function recordHistory($command, $description, $result, $output)
    {
        $schemaCalculation = [
            'Command' => $command,
            'Description' => $description,
            'Result' => $result,
            'Output' => $output,
            'Time' => date('m-d-Y H:i:s'),
        ];

        $pathFile = './data.json';
        if (!file_exists($pathFile)) {
            file_put_contents($pathFile, null);
        }

        $historyCalculation = file_get_contents($pathFile);

        $calculations = json_decode($historyCalculation, true);
        $calculations[] = json_decode(json_encode($schemaCalculation));
        $calculationsAsJson = json_encode($calculations);
        file_put_contents($pathFile, $calculationsAsJson);
    }
}
