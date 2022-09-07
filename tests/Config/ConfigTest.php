<?php

namespace eXistenZNL\PermCheck\Config;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var Config;
     */
    protected $config;

    public function setUp(): void
    {
        $this->config = new Config;
    }

    public function tearDown(): void
    {
        unset($this->config);
    }

    public function testIfSettingAndGettingExcludedDirsWorks()
    {
        $this->config->addExcludedDir('test/dir');
        $this->config->addExcludedDir('test/dir2');

        $this->assertEquals(
            (array) $this->config->getExcludedDirs(),
            array(
                'test/dir',
                'test/dir2'
            )
        );
    }

    public function testIfSettingAndGettingExcludedFilesWorks()
    {
        $this->config->addExcludedFile('test/dir/file1.sh');
        $this->config->addExcludedFile('test/dir2/file2.zip');

        $this->assertEquals(
            (array) $this->config->getExcludedFiles(),
            array(
                'test/dir/file1.sh',
                'test/dir2/file2.zip'
            )
        );
    }

    public function testIfSettingAndGettingExecutableFilesWorks()
    {
        $this->config->addExecutableFile('bin/runme.sh');
        $this->config->addExecutableFile('bin/runme.bat');

        $this->assertEquals(
            (array) $this->config->getExecutableFiles(),
            array(
                'bin/runme.sh',
                'bin/runme.bat'
            )
        );
    }
}
