<?php

namespace ADZbuzzDevEnv\Creators;

use ADZbuzzDevEnv\Console\Command;

class Linker extends FileManager
{
    protected $folders;
    protected $command;

    public function __construct($basePath, $folders)
    {
        parent::__construct($basePath);

        $this->folders = collect($folders);

        $this->command = new Command($basePath);
    }

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