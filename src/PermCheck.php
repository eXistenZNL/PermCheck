<?php

namespace Enrise\PermCheck;

class PermCheck
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $config;

    public function run()
    {
        $this->validate();
        $this->config = $this->loadConfig($this->params['config']);
        $files = $this->getFileList();

        $errors = [
            'minx' => [],
            'plusx' => [],
        ];

        while($files->valid()) {
            /* @var \SplFileInfo $file */
            $file = $files->current();

            if (!$file->isExecutable() && in_array($file->getPathname(), $this->config['executables'])) {
                $errors['plusx'][] = $file->getPathname();
            } elseif ($file->isExecutable() && !in_array($file->getPathname(), $this->config['executables'])) {
                $errors['minx'][] = $file->getPathname();
            }
            $files->next();
        }

        return $errors;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * Perform the various checks needed before we can start examining the code
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    protected function validate()
    {
        if (!isset($this->params['directory']) || $this->params['directory'] === false) {
            throw new \InvalidArgumentException('Missing argument --directory (-d)');
        }
        if (!isset($this->params['config']) || $this->params['config'] === false) {
            throw new \InvalidArgumentException('Missing argument --config (-c)');
        }
        if (!is_file($this->params['config'])) {
            throw new \RuntimeException('Configuration file does not exist');
        }
    }

    /**
     * Get a list of files that we can loop trough
     *
     * @return \Iterator
     */
    protected function getFileList()
    {
        if(count($this->config['directories']) === 0) {
            $files = new \RecursiveDirectoryIterator(getcwd(), \FilesystemIterator::SKIP_DOTS);
            $files = new \RecursiveIteratorIterator($files);
            return $files;
        }

        foreach($this->config['directories'] as $dir) {
            try {
                $dir = new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
                $dir = new \RecursiveIteratorIterator($dir);
                $files->append($dir);
            } catch (\UnexpectedValueException $e) {
                throw new \RuntimeException(
                    sprintf(
                        'The directory %s could not be found, check your config!',
                        $dir
                    )
                );
            }
        }
        return $files;
    }

    protected function loadConfig($config)
    {
        $xml = simplexml_load_file($config);

        $config = [
            'directories' => (array) $xml->directories->children()->dir,
            'executables' => (array) $xml->executables->children()->file,
        ];
        return $config;
    }
}
