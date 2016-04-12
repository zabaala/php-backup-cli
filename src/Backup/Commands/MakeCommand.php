<?php
namespace M2Digital\Backup\Commands;

use Dropbox\Client;
use Dropbox\WriteMode;
use M2Digital\Backup\FileManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command {
    
    public function configure() {
        $this->setName('make')
              ->setDescription('Make a new backup');
    }
    
    public function execute(InputInterface $input, OutputInterface $output) {

        $output->writeln('<info>Generating backup dump file...</info>');

        $config = $this->fileManager->getDatabaseConfig();

        $file = $this->fileManager->getBackupFileName();

        $command = sprintf(
            "mysqldump -h%s -u%s %s %s --routines > %s",
            $config->hostname,
            $config->username,
            property_exists($config, 'password') ? ('-p' . $config->password) : '',
            $config->database,
            $file
        );

        // exec mysql dump command
        shell_exec($command);

        $output->writeln('<info>Database dump was created...</info>');
        $output->writeln('<info>Uploading to dropbox...</info>');

        $dpClient = new Client($this->fileManager->getToken(), $this->getApplication()->getName());

        $dpPath = explode('/', $file);
        $dpPath = FileManager::DROPBOX_BACKUP_FOLDERNAME . FileManager::DS . end($dpPath);

        $dpClient->uploadFileFromString($dpPath, WriteMode::add(), file_get_contents($file));

        @unlink($file);

        $output->writeln('<info>Done!</info>');

        $this->showBackups($output);
    }
}