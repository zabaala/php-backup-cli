<?php
namespace M2Digital\Backup\Commands;

use Dropbox\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command {
    
    public function configure() {
        $this->setName('delete')
             ->setDescription('Delete a backup')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The Dropbox file path');
    }
    
    public function execute(InputInterface $input, OutputInterface $output) {

        $dpClient = new Client($this->fileManager->getToken(), $this->getApplication()->getName());
        $dpClient->delete($input->getOption('path'));

        $output->writeln('<comment>Path was deleted!</comment>');

        $this->showBackups($output);
    
    }
}