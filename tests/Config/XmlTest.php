<?php

namespace tests\Config;

use eXistenZNL\PermCheck\Config\Loader\Xml;

class XmlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Xml
     */
    protected $xml;

    /**
     * PHPUnit setup
     */
    public function setUp()
    {
        $config = new TestConfig();
        $this->xml = new Xml();
        $this->xml->setConfig($config);
    }

    /**
     * PHPUnit teardown
     */
    public function tearDown()
    {
        unset($this->xml);
    }

    /**
     * @dataProvider brokenXmlProvider
     * @expectedException \RuntimeException
     */
    public function testIfLoadingABrokenXmlFails($xml)
    {
        $this->xml->setData($xml);
        $this->xml->parse();
    }

    /**
     * @dataProvider correctXmlProvider
     */
    public function testIfLoadingACorrectXmlWorks($xml)
    {
        $this->xml->setData($xml);
        $this->xml->parse();
    }

    /**
     * @dataProvider excludesProvider
     */
    public function testIfExcludesAreReadFromTheConfig($xml, $data)
    {
        $this->xml->setData($xml);

        /* @var TestConfig $config */
        $config = $this->xml->parse();

        $this->assertEquals($config->dumpExcludedDirs(), $data['dirs']);
        $this->assertEquals($config->dumpExcludedFiles(), $data['files']);
        $this->assertEquals($config->dumpExecutableFiles(), $data['executables']);
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
            array('<permcheck></permcheck>')
        );
    }

    public function correctXmlProvider()
    {
        return array(
            array('<permcheck><excludes /><executables/></permcheck>'),
            array('<permcheck><excludes><file>bladi</file></excludes><executables/></permcheck>'),
        );
    }

    public function excludesProvider()
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
