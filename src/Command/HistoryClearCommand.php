<?php

namespace App\Calculator\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class HistoryClearCommand extends Command
{
    public function configure()
    {
        $this->setName('history:clear')
            ->setDescription('Clear calculator history')
        ;
    }

    public function handle(ConsoleOutput $output)
    {
        $file = './data.json';
        $data = '';
        file_put_contents($file, $data);
        $output->writeln('<fg=green>History cleared!</>');
    }

}
