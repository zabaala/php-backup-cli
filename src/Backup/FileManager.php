<?php

namespace M2Digital\Backup;

class FileManager
{
    /**
     * Directory separator const alias.
     *
     * @const string
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Dropbox token filename.
     *
     * @const string
     */
    const DROPBOX_TOKEN_FILENAME = 'dropbox.token';

    /**
     * Dropbox app filename.
     */
    const DROPBOX_APP_FILENAME = 'dropbox.app';

    /**
     * Database configuration filename.
     *
     * @const string
     */
    const DATABASE_CONFIG_FILENAME = 'database.conf';

    /**
     * Storage folder name.
     *
     * @const string
     */
    const STORAGE_FOLDERNAME = 'storage';

    /**
     * Config folder name.
     *
     * @const string
     */
    const CONFIG_FOLDERNAME = 'config';

    /**
     * Folder that stores backups on Dropbox.
     *
     * @const string
     */
    const DROPBOX_BACKUP_FOLDERNAME = '/mysql-backups';

    /**
     * Path of storage folder.
     *
     * @var string
     */
    protected $path;

    /**
     * Constructor.
     * Make the base path and creates config and storage folders.
     */
    public function __construct() {

        $this->path = getcwd() . self::DS;

        $this->createConfigFolder();
        $this->createStorageFolder();
    }

    /**
     * Get base path.
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Get storage path.
     *
     * @return string
     */
    public function getStoragePath() {
        return $this->getPath() . self::STORAGE_FOLDERNAME;
    }

    /**
     * Get config path.
     *
     * @return string
     */
    public function getConfigPath() {
        return $this->getPath() . self::CONFIG_FOLDERNAME;
    }


    /**
     * Get full path of Dropbox app config file.
     *
     * @return string
     */
    public function getAppFileName() {
        return $this->getConfigPath() . self::DS . self::DROPBOX_APP_FILENAME;
    }

    /**
     * Get full path of Dropbox access-token file.
     *
     * @return string
     */
    public function getTokenFileName() {
        return $this->getConfigPath() . self::DS . self::DROPBOX_TOKEN_FILENAME;
    }

    /**
     * @return string
     */
    public function getDatabaseFileName() {
        return $this->getConfigPath() . self::DS . self::DATABASE_CONFIG_FILENAME;
    }

    /**
     * Check if storage folder exists.
     * If not exists, create the storage folder.
     *
     * @return bool
     */
    private function createStorageFolder() {

        if( !is_dir($this->getStoragePath())) {
            mkdir($this->getStoragePath(), 0777, true);
        }

    }

    private function createConfigFolder() {

        if( !is_dir($this->getConfigPath())) {
            mkdir($this->getConfigPath(), 0777, true);
        }
    }


    /**
     * Get the Dropbox OAuth access-token.
     *
     * @return string
     * @throw \RuntimeException
     */
    public function getToken() {

        $content = file_get_contents($this->getTokenFileName());

        return $content;

    }

    /**
     * Get database configuration params.
     *
     * @return array
     */
    public function getDatabaseConfig() {
        $content = json_decode(file_get_contents($this->getDatabaseFileName()));
        return $content;
    }

    /**
     * Create the Dropbox access-token file.
     *
     * @param $accessToken
     */
    public function createTokenFile($accessToken) {
        $this->createFile(
            $this->getTokenFileName(),
            $accessToken
        );
    }

    /**
     * Create the Dropbox access-token file.
     *
     * @param $content
     */
    public function createDatabaseConfigFile($content) {

        $this->createFile(
            $this->getDatabaseFileName(),
            $content
        );
    }

    /**
     * Create Dropbox app config file.
     *
     * @param $appKey
     * @param $secretKey
     */
    public function createAppConfigFile($appKey, $secretKey) {
        $this->createFile(
            $this->getAppFileName(),
            json_encode(['key' => $appKey, 'secret' => $secretKey])
        );
    }

    /**
     * Create a file.
     *
     * @param $file
     * @param $content
     * @param string $mode
     */
    protected function createFile($file, $content, $mode = 'w+') {
        $fileResource = fopen($file, $mode) or die("Can't read/create file.");
        fwrite($fileResource, $content);
        fclose($fileResource);
    }

    public function getBackupFileName($type = '') {
        return sprintf('%s/backup_%s%s.sql'.$type, $this->getStoragePath(), date('YmdHis'), uniqid());
    }
}