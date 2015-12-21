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
     * The config where the data is stored in
     *
     * @var ConfigInterface;
     */
    protected $config;

    /**
     * The data to parse
     *
     * @var string
     */
    protected $data;

    /**
     * Constructor.
     *
     * @param string          $data   The data to parse.
     * @param ConfigInterface $config The config to fill.
     */
    public function __construct(
        $data,
        ConfigInterface $config
    ) {
        $this->data = $data;
        $this->config = $config;
    }
}
