<?php
namespace M2Digital\Backup\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseConfigCommand extends Command {
    
    public function configure() {
        $this->setName('db:config')
             ->setDescription('Create the database configuration file');
    }
    
    public function execute(InputInterface $input, OutputInterface $output) {

        $output->writeln('');
        $output->writeln('<info>Now we need to get the database configuration parameters.</info>');

        $hostname   = $this->askAQuestion('Enter the hostname');
        $dbname     = $this->askAQuestion('Enter the name of database');
        $username   = $this->askAQuestion('Enter the username of database');
        $password   = $this->askAQuestion('Enter the password of database [press ENTER for empty]', true);

        $config['hostname'] = $hostname;
        $config['database'] = $dbname;
        $config['username'] = $username;

        if( !is_null($password)){
            $config['password'] = $password;
        }

        $content = json_encode($config);

        $this->fileManager->createDatabaseConfigFile($content);

        $output->writeln('<info>Database configuration file was created successfully.</info>');

    }
}