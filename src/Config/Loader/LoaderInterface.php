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
     * Constructor
     *
     * @param string $data
     * @param ConfigInterface $config
     */
    public function __construct(
        $data,
        ConfigInterface $config
    );

    /**
     * Load the configuration, store it in the config bag, and return it.
     *
     * @return ConfigInterface;
     */
    public function parse();
}
