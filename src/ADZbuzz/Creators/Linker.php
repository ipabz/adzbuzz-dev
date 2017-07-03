<?php

namespace ADZbuzzDevEnv\Creators;

use ADZbuzzDevEnv\Console\Command;

class Linker extends FileManager
{
    /**
     * @var array
     */
    protected $folders;

    /**
     * @var ADZbuzzDevEnv\Console\Command
     */
    protected $command;

    /**
     * @param string $basePath 
     * @param array $folders
     */
    public function __construct($basePath, $folders)
    {
        parent::__construct($basePath);

        $this->folders = collect($folders);

        $this->command = new Command($basePath);
    }

    /**
     * Link directories
     * 
     * @return void
     */
    public function linkDirectories()
    {
        $this->folders->each(function($folder) {
            $fromLocation = str_replace('~', '/vagrant_data', $folder['map']);
            $toLocation = $folder['to'];
            $temp = explode('/', $toLocation);
            $www = '/var/www/html/' . end($temp);

            $this->command->run("sudo rm -rf $toLocation");
            $this->command->run("sudo rm -rf $www");
            $this->command->run("sudo ln -s $fromLocation $toLocation");
            $this->command->run("sudo ln -s $toLocation $www");
        });
    }
}