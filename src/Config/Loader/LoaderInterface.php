<?php

namespace eXistenZNL\PermCheck\Config\Loader;

use eXistenZNL\PermCheck\Config\ConfigInterface;

/**
 * Interface for the config loader
 *
 * @package eXistenZNL\PermCheck\Config\Loader
 */
interface LoaderInterface
{
    /**
     * Set the config object that needs filling.
     *
     * @param ConfigInterface $config The config that needs filling
     */
    public function setConfig(ConfigInterface $config);

    /**
     * Load the configuration, store it in the config bag, and return it.
     *
     * @return ConfigInterface;
     */
    public function load();
}
