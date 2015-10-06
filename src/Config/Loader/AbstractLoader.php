<?php

namespace eXistenZNL\PermCheck\Config\Loader;

use eXistenZNL\PermCheck\Config\ConfigInterface;

/**
 * Abstract class for the config loader
 *
 * @package eXistenZNL\PermCheck\Config\Loader
 */
abstract class AbstractLoader implements LoaderInterface
{
    /**
     * @var ConfigInterface;
     */
    protected $config;

    /**
     * Set the config object that needs filling.
     *
     * @param ConfigInterface $config The config that needs filling
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }
}
