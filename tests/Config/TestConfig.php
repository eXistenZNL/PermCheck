<?php

namespace tests\Config;

use eXistenZNL\PermCheck\Config\AbstractConfig;

class TestConfig extends AbstractConfig
{
    public function dumpExcludedDirs()
    {
        return (array) $this->excludedDirs;
    }

    public function dumpExcludedFiles()
    {
        return (array) $this->excludedFiles;
    }

    public function dumpExecutableFiles()
    {
        return (array) $this->executableFiles;
    }
}