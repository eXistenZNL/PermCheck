<?php

namespace eXistenZNL\PermCheck\Config\Loader;

use eXistenZNL\PermCheck\Config\ConfigInterface;

/**
 * Loads the config from a XML file
 *
 * @package eXistenZNL\PermCheck\Config\Loader
 */
class Xml extends AbstractLoader
{
    /**
     * @var string
     */
    protected $configFile;

    /**
     * @param string $configFile
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * Load the configuration and return it in an easy to use config bag.
     *
     * @return ConfigInterface
     *
     * @throws \RuntimeException
     */
    public function load()
    {
        if (!file_exists($this->configFile)) {
            throw new \RuntimeException(
                sprintf(
                    'Configuration file %s does not exist',
                    $this->configFile
                )
            );
        }
    }
}
