<?php

namespace ADZbuzzDevEnv\Console;

use ADZbuzzDevEnv\Exceptions\CommandException;

class Command
{
    protected $repository;
    protected $cwd;

    public function __construct($path)
    {
        $this->repository = $path;
    }

    public function run($cmd)
    {
        $cmd = $this->prepareCommand(func_get_args());

        exec($cmd, $output, $ret);

        if ($ret !== 0) {
            throw new CommandException("Command '$cmd' failed (exit-code $ret).", $ret);
        }

        return $this;
    }

    public function extract($cmd, $filter=null)
    {
        return $this->extractFromCommand($cmd, $filter);
    }

    protected function extractFromCommand($cmd, $filter = null)
    {
        $output = array();
        $exitCode = null;

        $this->begin();
        exec("$cmd", $output, $exitCode);
        $this->end();

        if ($exitCode !== 0 || !is_array($output)) {
            throw new CommandException("Command $cmd failed.");
        }

        if ($filter !== null) {
            $newArray = array();

            foreach ($output as $line) {
                $value = $filter($line);

                if ($value === false) {
                    continue;
                }

                $newArray[] = $value;
            }

            $output = $newArray;
        }

        if (!isset($output[0])) {
            return null;
        }

        return $output;
    }

    protected function begin()
    {
        if ($this->cwd === null) {
            $this->cwd = getcwd();
            chdir($this->repository);
        }

        return $this;
    }
        
    protected function end()
    {
        if (is_string($this->cwd)) {
            chdir($this->cwd);
        }

        $this->cwd = null;

        return $this;
    }
    
    protected static function prepareCommand(array $args)
    {
        $cmd = [];

        $programName = array_shift($args);

        foreach ($args as $arg) {
            $cmd = $cmd + $this->prepare($arg);
        }

        return "$programName " . implode(' ', $cmd);
    }

    protected function prepare($arg)
    {
        if (is_array($arg)) {
            return $this->extractCommandFromArray($arg);
        }

        if (is_scalar($arg) && !is_bool($arg)) {
            return escapeshellarg($arg);
        }

        return [];
    }

    protected function extractCommandFromArray(array $args)
    {
        $cmd = [];

        foreach ($args as $key => $value) {
            $_c = (is_string($key))
                ? "$key "
                : '';

            $cmd[] = $_c . escapeshellarg($value);
        }

        return $cmd;
    }
}
