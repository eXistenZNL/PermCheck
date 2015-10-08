<?php

namespace eXistenZNL\PermCheck;

use eXistenZNL\PermCheck\Config\ConfigInterface;
use eXistenZNL\PermCheck\Config\Loader\LoaderInterface as ConfigLoaderInterface;
use eXistenZNL\PermCheck\Message\BagInterface as MessageBagInterface;
use eXistenZNL\PermCheck\Reporter\Xml;

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
     * @var
     */
    protected $filesystem;

    /**
     * @var MessageBagInterface
     */
    protected $messageBag;

    /**
     * @var Xml;
     */
    protected $reporter;

    /**
     * @var string
     */
    protected $reportFile;

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
     * Set the path of the reportFile to write the XML report to
     *
     * @param string $reportFile The file to write the report to
     */
    public function setReportFile($reportFile)
    {
        $this->reportFile = $reportFile;
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

        // Do something
    }
}
