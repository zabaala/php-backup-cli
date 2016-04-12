<?php

namespace M2Digital\Backup\Commands;

use Dropbox\AppInfo;
use Dropbox\WebAuthNoRedirect;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DropboxGenerateTokenCommand extends Command
{
    public function configure() {
        $this->setName('dropbox:generate-token')
            ->setDescription('Generate dropbox access-token');
    }

    public function execute(InputInterface $input, OutputInterface $output) {

        $appInfo = AppInfo::loadFromJsonFile($this->fileManager->getAppFileName());

        $webAuth = new WebAuthNoRedirect($appInfo, $this->getApplication()->getName());

        $authorizeUrl = $webAuth->start();

        $output->writeln("1. Go to: " . $authorizeUrl);
        $output->writeln("2. Click \"Allow\" (you might have to log in first).");
        $output->writeln("3. Copy the authorization code.");

        $helper = new QuestionHelper();
        $question = new Question('Enter the Authorization Code here:', null);
        $bundle = $helper->ask(new ArgvInput(), new ConsoleOutput(), $question);

        list($accessToken, $dropboxUserId) = $webAuth->finish($bundle);

        $this->fileManager->createTokenFile($accessToken);

        $output->writeln("<info>Token file was created successfully.</info>");

    }
}