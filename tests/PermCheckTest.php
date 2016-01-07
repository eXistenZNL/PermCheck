<?php

namespace eXistenZNL\PermCheck;

use eXistenZNL\PermCheck\Config\Config;
use eXistenZNL\PermCheck\Config\Loader\Xml as XmlLoader;
use eXistenZNL\PermCheck\Filesystem\Filesystem;
use eXistenZNL\PermCheck\Message\Bag;
use eXistenZNL\PermCheck\Reporter\Xml as XmlReporter;
use Mockery\Mock;

class permCheckTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PermCheck
     */
    protected $permCheck;

    /**
     * @var Mock;
     */
    protected $config;

    /**
     * @var Mock;
     */
    protected $loader;

    /**
     * @var Mock;
     */
    protected $fileSystem;

    /**
     * @var Mock;
     */
    protected $messageBag;

    /**
     * @var Mock;
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
            '/does/not/exist/file1.sh' => true,
            '/does/not/exist/file2.txt' => false,
            '/does/not/exist/file3.sh' => false,
            '/does/not/exist/file4.txt' => true,
            '/does/not/exist/excluded/file5.txt' => true,
            '/does/not/exist/excluded2/file6.sh' => false,
        );
        foreach ($mocks as $file => $executable) {
            $file = \Mockery::mock(new \SplFileInfo($file));
            $file->shouldReceive('getName')->andReturn($file);
            $file->shouldReceive('isExecutable')->andReturn($executable);
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
