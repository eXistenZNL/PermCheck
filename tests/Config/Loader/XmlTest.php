<?php

namespace eXistenZNL\PermCheck\Config\Loader;

use eXistenZNL\PermCheck\Config\Config;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class XmlTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @dataProvider brokenXmlProvider
     */
    public function testIfLoadingABrokenXmlFails($data)
    {
        $this->expectException(\RuntimeException::class);

        /** @var Config|MockInterface $config */
        $config = \Mockery::mock(new Config());
        $xml = new Xml(
            $data,
            $config
        );

        $xml->parse();
    }

    /**
     * @dataProvider correctXmlProvider
     */
    public function testIfLoadingACorrectXmlWorks($data)
    {
        /** @var Config|MockInterface $config */
        $config = \Mockery::mock(new Config());
        $xml = new Xml(
            $data,
            $config
        );
        $xml->parse();
    }

    /**
     * @dataProvider correctXmlWithValidationDataProvider
     */
    public function testIfTheRightFilesAndFoldersAreLoadedIntoTheConfig($data, $files)
    {
        /** @var Config|MockInterface $config */
        $config = \Mockery::mock(new Config());
        $xml = new Xml(
            $data,
            $config
        );

        foreach ($files['files'] as $file) {
            $config->shouldReceive('addExcludedFile')
                ->once()
                ->withArgs(array($file))
                ->andReturn($config);
        }

        foreach ($files['dirs'] as $dir) {
            $config->shouldReceive('addExcludedDir')
                ->once()
                ->withArgs(array($dir))
                ->andReturn($config);
        }

        foreach ($files['executables'] as $executable) {
            $config->shouldReceive('addExecutableFile')
                ->once()
                ->withArgs(array($executable))
                ->andReturn($config);
        }

        $xml->parse();
    }

    public function brokenXmlProvider()
    {
        return array(
            array(345),
            array(null),
            array(false),
            array(array()),
            array(''),
            array('<xml></xml>'),
            array('<permcheck></permcheck>'),
            array('<permcheck><excludes /></permcheck>'),
            array('<permcheck><executables /></permcheck>'),
        );
    }

    public function correctXmlProvider()
    {
        return array(
            array('<permcheck><excludes /><executables/></permcheck>'),
            array('<permcheck><excludes><file>bladi</file></excludes><executables/></permcheck>'),
        );
    }

    public function correctXmlWithValidationDataProvider()
    {
        return array(
            array(
                '<permcheck>
                    <excludes>
                        <file>files/file1.php</file>
                        <file>files/file2.css</file>
                        <dir>another/directory</dir>
                    </excludes>
                    <executables/>
                </permcheck>',
                array(
                    'files' => array(
                        'files/file1.php',
                        'files/file2.css',
                    ),
                    'dirs' => array(
                        'another/directory',
                    ),
                    'executables' => array(),
                ),
            ),
            array(
                '<permcheck>
                    <excludes>
                        <file>files/file3.sh</file>
                    </excludes>
                    <executables>
                      <file>bin/runme.sh</file>
                    </executables>
                </permcheck>',
                array(
                    'files' => array(
                        'files/file3.sh',
                    ),
                    'dirs' => array(),
                    'executables' => array(
                        'bin/runme.sh',
                    ),
                ),
            ),
            array(
                '<permcheck>
                    <excludes />
                    <executables>
                      <file>var/db/hidden/evilhack.sh</file>
                    </executables>
                </permcheck>',
                array(
                    'files' => array(),
                    'dirs' => array(),
                    'executables' => array(
                        'var/db/hidden/evilhack.sh',
                    ),
                ),
            ),
        );
    }
}
