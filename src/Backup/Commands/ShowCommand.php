<?php
namespace M2Digital\Backup\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command {

    public function configure() {
        $this->setName('show')
            ->setDescription('Show all backups');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output) {

        $this->showBackups($output);
    
    }


}