<?php

namespace ADZbuzzDevEnv;

use Symfony\Component\Yaml\Yaml;
use ADZbuzzDevEnv\Creators\Linker;
use ADZbuzzDevEnv\Creators\VirtualHost;
use Symfony\Component\Yaml\Exception\ParseException;

class App
{
    protected $basePath;
    protected $configYamlPath;
    protected $config;
    protected $linker;
    protected $virtualHost;

    public function __construct($basePath)
    {
        $this->configYamlPath = $basePath . 'stubs/Adzbuzz.yaml';
        $this->basePath = $basePath;

        $this->config = $this->parseConfig();

        $this->linker = new Linker($this->basePath, $this->config['folders']);

        $this->virtualHost = new VirtualHost($this->basePath, $this->config['sites']);
    }

    public function start()
    {
        $this->linker->linkDirectories();
        $this->virtualHost->generateVirtualHosts();
        // print "\n\n";
        // print_r($this->config);
    }

    protected function parseConfig()
    {
        try {
            $config = Yaml::parse(file_get_contents($this->configYamlPath));
        } catch (ParseException $e) {
            echo "Unable to parse the YAML string: " . $e->getMessage();
        }

        return $config;
    }
}
