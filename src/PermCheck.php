<?php

namespace eXistenZNL\PermCheck;

use eXistenZNL\PermCheck\Config\ConfigInterface;
use eXistenZNL\PermCheck\Config\Loader\LoaderInterface as ConfigLoaderInterface;
use eXistenZNL\PermCheck\Filesystem\FilesystemInterface;
use eXistenZNL\PermCheck\Message\Bag;
use eXistenZNL\PermCheck\Message\BagInterface as MessageBagInterface;
use eXistenZNL\PermCheck\Reporter\ReporterInterface;
use SplFileInfo;

/**
 * The main PermCheck controller class
 *
 * @package eXistenZNL\PermCheck
 */
class PermCheck
{
    /**
     * @var ConfigLoaderInterface
     */
    protected $loader;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * @var MessageBagInterface
     */
    protected $messageBag;

    /**
     * @var ReporterInterface;
     */
    protected $reporter;

    /**
     * @var string
     */
    protected $reportFile;

    /**
     * @var string
     */
    protected $directory;

    /**
     * Constructor
     *
     * @param ConfigLoaderInterface $loader
     * @param FilesystemInterface $filesystem
     * @param MessageBagInterface $messageBag
     * @param ReporterInterface $reporter
     */
    public function __construct(
        ConfigLoaderInterface $loader,
        FilesystemInterface $filesystem,
        MessageBagInterface $messageBag,
        ReporterInterface $reporter,
        $directory
    ) {
        $this->loader = $loader;
        $this->filesystem = $filesystem;
        $this->messageBag = $messageBag;
        $this->reporter = $reporter;
        $this->directory = $directory;
    }

    /**
     * Get the messageBag that holds the error messages
     *
     * @return MessageBagInterface
     */
    public function getMessageBag()
    {
        return $this->messageBag;
    }

    /**
     * Get a list of files that we can loop trough
     *
     * @throws \RuntimeException
     * @return \Iterator
     */
    protected function getFileList()
    {
    }

    /**
     * Run the permission check and return any errors
     *
     * @return array
     */
    public function run()
    {
        $this->config = $this->loader->parse();

        $this->filesystem->setConfig($this->config);
        $files = $this->filesystem->getFiles();

        // Now we check all the files against the config
        while ($files->valid()) {
            /* @var SplFileInfo $file */
            $file = $files->current();

            $filename = $this->getRelativeFilename($file);

            // Skip excluded files, of course.
            if ($this->isExcluded($filename)) {
                $files->next();
                continue;
            }

            if (!$this->shouldBeExecutable($filename) && $file->isExecutable()) {
                $this->messageBag->addMessage($file->getPathname(), 'minx');
                $files->next();
                continue;
            }

            if ($this->shouldBeExecutable($filename) && !$file->isExecutable()) {
                $this->messageBag->addMessage($file->getPathname(), 'plusx');
                $files->next();
                continue;
            }

            $files->next();
        }
    }

    public function getErrors()
    {
        return $this->messageBag;
    }

    protected function isExcluded($filename)
    {
        foreach ($this->config->getExcludedDirs() as $excludedDir)
        {
            if (strpos($filename, $excludedDir) === 0) {
                return true;
            }
        }
        return false;
    }

    protected function shouldBeExecutable($filename)
    {
        foreach ($this->config->getExecutableFiles() as $exFile)
        {
            if ($filename === $exFile) {
                return true;
            }
        }
        return false;
    }

    protected function getRelativeFilename(SplFileInfo $file)
    {
        $filename = $file->getPathname();
        $regex = sprintf('#^(%s)/(.+)#', $this->directory);
        $matches = [];

        preg_match(
            $regex,
            $filename,
            $matches
        );

        return $matches[2];
    }
}
