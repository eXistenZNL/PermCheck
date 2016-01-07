<?php

namespace eXistenZNL\PermCheck\Filesystem;

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
        $config = \Mockery::mock('eXistenZNL\PermCheck\Config\Config');
        $filesystem = new Filesystem($config, dirname(__FILE__));

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
