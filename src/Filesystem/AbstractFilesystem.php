<?php

namespace eXistenZNL\PermCheck\Filesystem;

use AppendIterator;
use eXistenZNL\PermCheck\Config\ConfigInterface;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use Iterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * The abstract class for the filesystem
 *
 * @package eXistenZNL\PermCheck\Filesystem
 */
abstract class AbstractFilesystem implements FilesystemInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var string
     */
    protected $directory;

    /**
     * Set the config to use
     *
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function setDirectory($directory)
    {
        if (substr($directory, -1) !== '/') {
            $directory .= '/';
        }
        $this->directory = $directory;
    }

    /**
     * Give back a list of all files in a given directory, recursively
     * This returns the filename relative to the given directory.
     *
     * @return Iterator
     */
    public function getFiles()
    {
        $iterator = new RecursiveDirectoryIterator(
            $this->directory,
            FilesystemIterator::SKIP_DOTS
        );
        $iterator = new RecursiveIteratorIterator($iterator);
        $iterator->rewind();

        return $iterator;
    }
}
