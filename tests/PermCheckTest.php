<?php

namespace eXistenZNL\PermCheck;

use eXistenZNL\PermCheck\Config\Config;
use eXistenZNL\PermCheck\Config\Loader\LoaderInterface;
use eXistenZNL\PermCheck\Config\Loader\Xml as XmlLoader;
use eXistenZNL\PermCheck\Filesystem\Filesystem;
use eXistenZNL\PermCheck\Filesystem\FilesystemInterface;
use eXistenZNL\PermCheck\Message\Bag;
use eXistenZNL\PermCheck\Message\BagInterface;
use eXistenZNL\PermCheck\Reporter\ReporterInterface;
use eXistenZNL\PermCheck\Reporter\Xml as XmlReporter;
use Mockery\MockInterface;

class PermCheckTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PermCheck
     */
    protected $permCheck;

    /**
     * @var MockInterface|Config
     */
    protected $config;

    /**
     * @var MockInterface|LoaderInterface
     */
    protected $loader;

    /**
     * @var MockInterface|FilesystemInterface
     */
    protected $fileSystem;

    /**
     * @var MockInterface|BagInterface
     */
    protected $messageBag;

    /**
     * @var MockInterface|ReporterInterface
     */
    protected $reporter;

    public function setUp()
    {
        $data = <<< ENDXML
        <permcheck>
            <excludes>
                <file>excluded/file5.txt</file>
                <dir>excluded2</dir>
            </excludes>
            <executables>
                <file>file1.sh</file>
                <file>file3.sh</file>
            </executables>
        </permcheck>
ENDXML;

        $this->config = \Mockery::mock(new Config());

        $this->loader = \Mockery::mock(new XmlLoader(
            $data,
            $this->config
        ));

        $this->fileSystem = \Mockery::mock(new Filesystem(
            $this->config,
            '/does/not/exist'
        ));

        $files = new \ArrayIterator();
        $mocks = array(
            '/does/not/exist/file1.sh' => array(true, false),
            '/does/not/exist/file2.txt' => array(false, false),
            '/does/not/exist/file3.sh' => array(false, false),
            '/does/not/exist/file4.txt' => array(true, false),
            '/does/not/exist/excluded/file5.txt' => array(true, false),
            '/does/not/exist/excluded2/file6.sh' => array(false, false),
            '/does/not/exist/symlink' => array(true, true),
        );
        foreach ($mocks as $file => $properties) {
            /** @var MockInterface|\SplFileInfo $file */
            $file = \Mockery::mock(new \SplFileInfo($file));
            $file->shouldReceive('getName')->andReturn($file);
            $file->shouldReceive('isExecutable')->andReturn($properties[0]);
            $file->shouldReceive('isLink')->andReturn($properties[1]);
            $files->append($file);
        }
        $this->fileSystem->shouldReceive('getFiles')->andReturn($files);

        $this->messageBag = \Mockery::mock(new Bag());

        $this->reporter = \Mockery::mock(new XmlReporter());

        $this->permCheck = new PermCheck(
            $this->loader,
            $this->config,
            $this->fileSystem,
            $this->messageBag,
            $this->reporter,
            '/does/not/exist'
        );
    }

    public function tearDown()
    {
        $this->permCheck = null;
        \Mockery::close();
    }

    public function testRunningPermCheckGetsTheRightResults()
    {
        $this->permCheck->run();
        $bag = $this->permCheck->getMessageBag();

        $this->assertEquals(
            $bag->getMessages('plusx'),
            array('/does/not/exist/file3.sh')
        );

        $this->assertEquals(
            $bag->getMessages('minx'),
            array('/does/not/exist/file4.txt')
        );
    }
}
