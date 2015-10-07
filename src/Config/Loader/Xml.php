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
     * Load the configuration and return it in an easy to use config bag.
     *
     * @return ConfigInterface
     *
     * @throws \RuntimeException
     */
    public function parse()
    {
        if (!is_string($this->data)) {
            throw new \RuntimeException('The given data is no valid string');
        }
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($this->data);
        if ($xml === false) {
            throw new \RuntimeException('Error during the loading of the XML file');
        }
        if (!isset($xml->executables) || !isset($xml->excludes)) {
            throw new \RuntimeException('Missing configuration elements');
        }

        $data = array(
            'excludes' => array(),
            'executables' => array(),
        );

        foreach ($xml->excludes->children()->file as $element) {
            $data['excludes'][] = (string) $element;
        }

        foreach ($xml->executables->children() as $element) {
            $data['executables'][] = (string) $element;
        }

        return $data;

    }
}
