<?php

namespace eXistenZNL\PermCheck\Filesystem;
use eXistenZNL\PermCheck\Config\ConfigInterface;
use RecursiveIteratorIterator;

/**
 * The interface for the message bag
 *
 * @package eXistenZNL\PermCheck\Filesystem
 */
interface FilesystemInterface
{
    /**
     * Set the directory up for scanning
     *
     * @param string $directory
     */
    public function setDirectory($directory);

    /**
     * Set the config to use
     *
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config);

    /**
     * Get a list of all files in a given directory,
     * in a single flat iterator.
     *
     * @return RecursiveIteratorIterator
     */
    public function getFiles();
}
