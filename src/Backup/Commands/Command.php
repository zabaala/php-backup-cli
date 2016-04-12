<?php

namespace M2Digital\Backup\Commands;

use Dropbox\Client;
use M2Digital\Backup\FileManager;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Command extends SymfonyCommand
{

    /**
     * @var FileManager
     */
    public $fileManager;

    public function __construct() {

        $this->fileManager = new FileManager;

        parent::__construct();
    }

    /**
     * Make a question on command-line.
     *
     * @param string $question
     * @param bool $setHidden
     *
     * @return string
     */
    protected function askAQuestion($question, $setHidden = false) {
        $helper = new QuestionHelper();
        $questionObj = new Question($question . ': ', null);

        if ($setHidden) {
            $questionObj->setHidden(true);
        }

        return $helper->ask(new ArgvInput(), new ConsoleOutput(), $questionObj);
    }

    /**
     * @param OutputInterface $output
     */
    protected function showBackups(OutputInterface $output)
    {
        $token = $this->fileManager->getToken();

        $dpClient = new Client($token, $this->getApplication()->getName());
        $folders = $dpClient->getMetadataWithChildren(FileManager::DROPBOX_BACKUP_FOLDERNAME);

        $content = $folders['contents'];

        $table = new Table($output);

        $table->setHeaders([
            'path', 'created_at', 'updated_at', 'size'
        ]);

        if (!count($content)) {
            $output->writeln('<info>Backup folder is empty.</info>');
            exit(1);
        }

        $data = [];

        for ($i = 0; $i < count($content); $i++) {
            $data[$i]['path'] = $content[$i]['path'];
            $data[$i]['created_at'] = $content[$i]['client_mtime'];
            $data[$i]['updated_at'] = $content[$i]['modified'];
            $data[$i]['size'] = $content[$i]['size'];
        }

        $table->addRows($data)
            ->render();
    }
}