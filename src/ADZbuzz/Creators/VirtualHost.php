<?php

namespace ADZbuzzDevEnv\Creators;

use ADZbuzzDevEnv\Console\Command;

class VirtualHost extends FileManager
{
    protected $sites;

    public function __construct($basePath, $sites)
    {
        parent::__construct($basePath);

        $this->sites = collect($sites);

        $this->command = new Command($basePath);
    }

    public function generateVirtualHosts()
    {
        $contents = $this->read('stubs/virtualhost.stub');
        
        $this->sites->each(function ($site) use ($contents) {
            $map = $site['map'];
            $to = $site['to'];

            $prepContents = $this->prepareContent($contents, $map, $to);
            $this->createVirtualHost($prepContents, $map);
        });
    }

    protected function prepareContent($contents, $map, $to)
    {
        $temp = explode('/', $to);
        $publicHmtl = '/var/www/html/' . $temp[count($temp)-2] . '/' . $temp[count($temp)-1];

        $data = [
            'ServerName coolexample.com'                               => 'ServerName ' . $map,
            'ServerAlias www.coolexample.com'                          => 'ServerAlias www.' . $map,
            'DocumentRoot /var/www/coolexample.com/public_html'        => 'DocumentRoot ' . $publicHmtl,
            'ErrorLog /var/www/coolexample.com/error.log'              => 'ErrorLog ' . $publicHmtl . '/error.log',
            'CustomLog /var/www/coolexample.com/requests.log combined' => 'CustomLog ' . $publicHmtl . '/requests.log combined'
        ];

        foreach ($data as $replaceThis => $replaceWith) {
            $contents = str_replace($replaceThis, $replaceWith, $contents);
        }

        return $contents;
    }

    protected function createVirtualHost($contents, $map)
    {
        $siteAvailable = '/etc/httpd/sites-available/' . $map . '.conf';
        $siteEnabled = '/etc/httpd/sites-enabled/' . $map . '.conf';

        $this->command->run("sudo echo '$contents' > $siteAvailable");
        $this->command->run("sudo ln -s $siteAvailable $siteEnabled");
    }
}
