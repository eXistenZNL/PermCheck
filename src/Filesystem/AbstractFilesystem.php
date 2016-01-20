<?php

namespace eXistenZNL\PermCheck\Filesystem;

use eXistenZNL\PermCheck\Config\ConfigInterface;
use FilesystemIterator;
use Iterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

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
     * AbstractFilesystem constructor.
     *
     * @param ConfigInterface $config    The config to use.
     * @param string          $directory The directory to scan.
     */
    public function __construct(
        ConfigInterface $config,
        $directory
    ) {
        if (substr($directory, -1) !== '/') {
            $directory .= '/';
        }
        $this->directory = $directory;
        $this->config = $config;
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
