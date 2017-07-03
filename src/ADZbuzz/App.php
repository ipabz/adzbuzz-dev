<?php

namespace ADZbuzzDevEnv;

use Symfony\Component\Yaml\Yaml;
use ADZbuzzDevEnv\Creators\Linker;
use ADZbuzzDevEnv\Creators\VirtualHost;
use Symfony\Component\Yaml\Exception\ParseException;

class App
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $configYamlPath;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var ADZbuzzDevEnv\Creators\Linker
     */
    protected $linker;

    /**
     * @var ADZbuzzDevEnv\Creators\VirtualHost
     */
    protected $virtualHost;

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->configYamlPath = $basePath . 'Adzbuzz.yaml';
        $this->basePath = $basePath;

        $this->config = $this->parseConfig();

        $this->linker = new Linker($this->basePath, $this->config['folders']);

        $this->virtualHost = new VirtualHost($this->basePath, $this->config['sites']);
    }

    /**
     * Do it's job
     * 
     * @return void
     */
    public function start()
    {
        $this->linker->linkDirectories();

        $this->virtualHost->generateVirtualHosts();

        // print "\n\n";
        // print_r($this->config);
    }

    /**
     * Parse config file
     * 
     * @return array
     */
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
