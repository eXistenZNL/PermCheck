<?php

namespace eXistenZNL\PermCheck;

use eXistenZNL\PermCheck\Config\ConfigInterface;
use eXistenZNL\PermCheck\Config\Loader\LoaderInterface as ConfigLoaderInterface;
use eXistenZNL\PermCheck\Message\BagInterface as MessageBagInterface;
use eXistenZNL\PermCheck\Reporter\Xml;

class PermCheck
{
    /**
     * @var ConfigLoaderInterface
     */
    protected $loader;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var
     */
    protected $filesystem;

    /**
     * @var MessageBagInterface;
     */
    protected $messageBag;

    /**
     * @var Xml;
     */
    protected $reporter;

    /**
     * Run the permission check and return any errors
     *
     * @return array
     */
    public function run()
    {
        $this->config->load();

        // Do something
    }

    /**
     * Get the messageBag that contains the error messages
     *
     * @return
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
}
