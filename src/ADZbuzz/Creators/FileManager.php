<?php

namespace ADZbuzzDevEnv\Creators;

use League\Flysystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use League\Flysystem\MountManager;
use League\Flysystem\Adapter\Local;
use ADZbuzzDevEnv\Exceptions\FileNotFoundException;

abstract class FileManager
{
    protected $basePath;
    protected $manager;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;

        $this->manager = new MountManager([
            'local' => new Filesystem(new Local($this->basePath))
        ]);
    }

    public function read($file)
    {
        if (! file_exists($file)) {
            throw new FileNotFoundException('Unable to read file: ' . $file);
        }

        return $filesystem->read($file);
    }
}