<?php


namespace App\Calculator\Command;


use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HistoryListCommand extends Command
{

    protected function configure()
    {
        $this->setName('history:list')
            ->setDescription('show calculation history')
            ->addArgument('argumens', InputArgument::IS_ARRAY,'Argument to filter');
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $file = './data.json';
        $histories = [];

        if (file_exists($file) && filesize($file) > 0) {
            $histories = $this->tableHistory($input);
        }

        if (sizeof($histories) < 1) {
            $this->output->writeln("<fg=green>History is empty !</>");
        } else {
            $table = new Table($output);
            $table
                ->setHeaderTitle("History Calculations Table")
                ->setStyle((new TableStyle())->setHorizontalBorderChars('='))
                ->setHeaders(['No', 'Command', 'Description', 'Result', 'Output', 'Time'])
                ->setRows($histories)
                ->render();
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->handle($input, $output);

        return self::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    protected function tableHistory(InputInterface $input): array
    {
        $historyCalculations = file_get_contents('./data.json');
        $histories = (array) json_decode($historyCalculations, true);
        $commands = $input->getArgument('argumens');

        return $this->setSchemaHistoryToRowsTable($histories,$commands);
    }

    public function setSchemaHistoryToRowsTable($histories, $commands)
    {
        $calculations = [];
        $increment = 1;
        if (sizeof($commands) > 0) {
            foreach ($histories as $history) {
                if (in_array(strtolower($history['Command']),$commands)) {
                    $calculations[] = $this->schemaHistory($history, $increment);
                    $increment++;
                }
            }
        } else {
            foreach ($histories as $history) {
                $calculations[] = $this->schemaHistory($history, $increment);
                $increment++;
            }
        }

        return $calculations;
    }
    public function schemaHistory($history, $increment)
    {
        return array(
                'ID'=> $increment,
                'Command'=> $history['Command'],
                'Description'=> $history['Description'],
                'Result'=> $history['Result'],
                'Output'=> $history['Output'],
                'Time'=> $history['Time'],
            );
    }

}