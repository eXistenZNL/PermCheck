<?php

namespace eXistenZNL\PermCheck;

use eXistenZNL\PermCheck\Config\ConfigInterface;
use eXistenZNL\PermCheck\Config\Loader\LoaderInterface as ConfigLoaderInterface;
use eXistenZNL\PermCheck\Filesystem\FilesystemInterface;
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
     * @param ConfigLoaderInterface $loader     The config loader.
     * @param ConfigInterface       $config     The config.
     * @param FilesystemInterface   $filesystem The filesystem.
     * @param MessageBagInterface   $messageBag The message bag.
     * @param ReporterInterface     $reporter   The reporter.
     * @param string                $directory  The directory to scan.
     */
    public function __construct(
        ConfigLoaderInterface $loader,
        ConfigInterface $config,
        FilesystemInterface $filesystem,
        MessageBagInterface $messageBag,
        ReporterInterface $reporter,
        $directory
    ) {
        $this->loader = $loader;
        $this->config = $config;
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
     * Run the permission check and return any errors
     *
     * @return void
     */
    public function run()
    {
        $this->loader->parse();
        $files = $this->filesystem->getFiles();

        // Now we check all the files against the config
        while ($files->valid()) {
            /* @var SplFileInfo $file */
            $file = $files->current();

            // Skip symlinks as they are always 0777
            if ($file->isLink()) {
                $files->next();
                continue;
            }

            $filename = $this->getRelativeFilename($file);

            // Skip excluded files, of course.
            if ($this->isExcluded($filename)) {
                $files->next();
                continue;
            }

            $fileShouldBeExecutable = $this->shouldBeExecutable($filename);
            if (!$fileShouldBeExecutable && $file->isExecutable()) {
                $this->messageBag->addMessage($file->getPathname(), 'minx');
                $files->next();
                continue;
            }

            if ($fileShouldBeExecutable && !$file->isExecutable()) {
                $this->messageBag->addMessage($file->getPathname(), 'plusx');
                $files->next();
                continue;
            }

            $files->next();
        }
    }

    /**
     * Check whether the given file should be excluded.
     *
     * @param string $filename The filename to check.
     *
     * @return boolean
     */
    protected function isExcluded($filename)
    {
        foreach ($this->config->getExcludedFiles() as $excludedFile) {
            if ($filename === $excludedFile) {
                return true;
            }
        }
        foreach ($this->config->getExcludedDirs() as $excludedDir) {
            if (strpos($filename, $excludedDir) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether the given file should be executable.
     *
     * @param string $filename The filename to check.
     *
     * @return boolean
     */
    protected function shouldBeExecutable($filename)
    {
        foreach ($this->config->getExecutableFiles() as $exFile) {
            if ($filename === $exFile) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the relative name of the given file.
     *
     * @param SplFileInfo $file The file to get the relative name for.
     *
     * @return string
     */
    protected function getRelativeFilename(SplFileInfo $file)
    {
        $filename = $file->getPathname();
        $regex = sprintf('#^(%s)/(.+)#', $this->directory);
        $matches = array();

        preg_match(
            $regex,
            $filename,
            $matches
        );

        return $matches[2];
    }
}
