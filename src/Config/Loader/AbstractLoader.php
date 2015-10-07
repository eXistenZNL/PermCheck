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
     * @var mixed
     */
    protected $data;

    /**
     * Set the config object that needs filling.
     *
     * @param ConfigInterface $config The config that needs filling
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Set the data that should be parsed
     *
     * @param mixed $data The data that should be parsed
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
