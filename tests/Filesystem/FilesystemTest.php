<?php

namespace eXistenZNL\PermCheck\Filesystem;

use eXistenZNL\PermCheck\Config\Config;
use Mockery\MockInterface;

class FilesystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    public function tearDown()
    {
        \Mockery::close();
    }

    public function testIfRetrievingTheFilesWorks()
    {
        /** @var Config|MockInterface $config */
        $config = \Mockery::mock(new Config());
        $filesystem = new Filesystem($config, __DIR__);

        $files = array(
            __FILE__
        );

        $result = array();
        foreach ($filesystem->getFiles() as $file) {
            $result[] = $file->getPathname();
        }

        $this->assertEquals($files, $result);
    }
}
