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
     * AbstractFilesystem constructor.
     *
     * @param ConfigInterface $config    The config to use.
     * @param string          $directory The directory to scan.
     */
    public function __construct(
        ConfigInterface $config,
        $directory
    );

    /**
     * Get a list of all files in a given directory,
     * in a single flat iterator.
     *
     * @return RecursiveIteratorIterator
     */
    public function getFiles();
}
