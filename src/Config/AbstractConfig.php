<?php

namespace eXistenZNL\PermCheck\Config;

/**
 * The abstract class for the config
 *
 * @package eXistenZNL\PermCheck\Config
 */
abstract class AbstractConfig implements ConfigInterface
{
    /**
     * @var \ArrayIterator
     */
    protected $excludedFiles;

    /**
     * @var \ArrayIterator
     */
    protected $excludedDirs;

    /**
     * @var \ArrayIterator
     */
    protected $executableFiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->excludedFiles = new \ArrayIterator();
        $this->excludedDirs = new \ArrayIterator();
        $this->executableFiles = new \ArrayIterator();
    }

    /**
     * Add a file that's excluded from checking
     *
     * @param string $file The file that's excluded from checking
     */
    public function addExcludedFile($file)
    {
        $this->excludedFiles->append($file);
    }

    /**
     * Add a directory that's excluded from checking
     *
     * @param string $dir The directory that's excluded from checking
     */
    public function addExcludedDir($dir)
    {
        $this->excludedDirs->append($dir);
    }

    /**
     * Add a file that's supposed to be executable
     *
     * @param string $file The file that should be executable
     */
    public function addExecutableFile($file)
    {
        $this->executableFiles->append($file);
    }

    /**
     * Get the excluded dirs
     *
     * @return \ArrayIterator
     */
    public function getExcludedDirs()
    {
        return $this->excludedDirs;
    }

    /**
     * Get the excluded files
     *
     * @return \ArrayIterator
     */
    public function getExcludedFiles()
    {
        return $this->excludedFiles;
    }

    /**
     * Get the executable files
     *
     * @return \ArrayIterator
     */
    public function getExecutableFiles()
    {
        return $this->executableFiles;
    }
}
