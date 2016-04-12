<?php
namespace M2Digital\Backup\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropboxInitCommand extends Command {

    public function configure() {
        $this->setName('dropbox:config')
              ->setDescription('Create Dropbox configuration file');
    }
    
    public function execute(InputInterface $input, OutputInterface $output) {
        $this->askForKeys($output);
    }

    /**
     * Ask for the app and secret Keys.
     *
     * @param OutputInterface $output
     */
    protected function askForKeys(OutputInterface $output)
    {
        $output->writeln('<info>Go to the https://www.dropbox.com/developers/ and create a new app.</info>');

        $appKey = $this->askAQuestion('Enter the App Key');
        $secretKey = $this->askAQuestion('Enter the Secret Key');

        $this->fileManager->createAppConfigFile($appKey, $secretKey);

        $output->writeln('<info>The Dropbox config file was created successfully.</info>');

    }




}