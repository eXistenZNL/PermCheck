<?php

namespace eXistenZNL\PermCheck\Config;

/**
 * Interface ConfigInterface
 *
 * @package eXistenZNL\PermCheck\Config
 */
interface ConfigInterface
{
    /**
     * Add a file that's excluded from checking
     *
     * @param string $file The file that's excluded from checking
     */
    public function addExcludedFile($file);

    /**
     * Add a directory that's excluded from checking
     *
     * @param string $dir The directory that's excluded from checking
     */
    public function addExcludedDir($dir);

    /**
     * Add a file that's supposed to be executable
     *
     * @param string $file The file that should be executable
     */
    public function addExecutableFile($file);
}
